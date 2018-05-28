<?php

namespace app\actions;

use app\core\DbManager;
use app\core\View;
use app\models\Task;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

final class TaskCreateAction
{
    /**
     * @var View
     */
    private $view;
    /**
     * @var DbManager
     */
    private $db;

    public function __construct(View $view, DbManager $db)
    {
        $this->view = $view;
        $this->db = $db;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $task = new Task();

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $task->username = $data['username'];
            $task->email = $data['email'];
            $task->text = $data['text'];
            $this->save($task);

            return new RedirectResponse('/tasks/view/' . $this->db->lastInsertId());
        }

        return new HtmlResponse($this->view->render('create', [
            'model' => $task,
        ]));
    }

    /**
     * @param Task $task
     * @return bool
     */
    private function save(Task $task): bool
    {
        $query = $this->db->prepare('INSERT INTO task (username, email, text) VALUES(:username, :email, :text)');
        $query->execute([
            'username' => $task->username,
            'email' => $task->email,
            'text' => $task->text,
        ]);

        return true;
    }
}
