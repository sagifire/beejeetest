<?php

namespace app\controllers;

use app\Application;
use app\helpers\SortLink;
use app\ViewController;
use app\models\Task as TaskModel;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Task
 *
 * @package app\controllers
 */
class Task extends ViewController
{
    /**
     * @var array
     */
    public $onlyAdminAccess = ['edit'];

    /**
     * @return false|string
     */
    public function index()
    {
        $this->pageTitle = 'Список задач';

        $query = TaskModel::query();

        list($sortColumn, $descending) = SortLink::parse();
        if (in_array($sortColumn, ['username', 'email', 'status'])) {
            $query->orderBy($sortColumn, $descending ? 'desc' : 'asc');
        }

        Paginator::currentPageResolver(function ($pageName = 'page') {
            return Application::getInstance()->request->get($pageName, 1);
        });

        $list = $query->paginate(self::DEFAULT_PER_PAGE);

        return $this->render('index', [
            'list' => $list,
            'sortColumn' => $sortColumn,
            'descending' => $descending,
        ]);
    }

    /**
     * @return false|string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function create()
    {
        $this->pageTitle = 'Создание задачи';
        $errors = new MessageBag();
        $formData = new ParameterBag();

        $requestService = Application::getInstance()->request;

        if ($requestService->isPost()) {
            $formData = $requestService->request;
            /** @var \Illuminate\Validation\Validator $validator */
            $validator = Application::getInstance()->validator->make($formData->all(), [
                'username' => 'required|max:255',
                'email' => 'required|email|max:255',
                'description' => 'required|max:4095',
            ]);

            if ($validator->passes()) {
                $model = new TaskModel();
                $model->fill($formData->all());
                $model->status = 0;
                $model->save();

                Application::getInstance()->session->getFlashBag()->set('success', 'Задача создана');

                return $this->redirect('/');
            } else {
                $errors = $validator->messages();
            }
        }

        return $this->render('create', [
            'formData' => $formData,
            'errors' => $errors,
        ]);
    }

    /**
     * @param $id
     *
     * @return false|string|\Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit($id)
    {
        $taskModel = TaskModel::find($id)->first();

        if ($taskModel) {
            $this->pageTitle = 'Изменение задачи';
            $errors = new MessageBag();
            $formData = new ParameterBag($taskModel->toArray());
            $formData->set('completed', $taskModel->isCompleted());

            $requestService = Application::getInstance()->request;

            if ($requestService->isPost()) {
                $formData->add($requestService->request->all());
                $validator = Application::getInstance()->validator->make($formData->all(), [
                    'description' => 'required|max:4095',
                    'completed' => 'required|bool',
                ]);

                if ($validator->passes()) {
                    $taskModel->description = $formData->get('description');
                    $taskModel->setCompleted($formData->get('completed'));
                    $taskModel->save();

                    Application::getInstance()->session->getFlashBag()->set('success', 'Задача изменена');

                    return $this->redirect('/');
                } else {
                    $errors = $validator->messages();
                }
            }

            return $this->render('edit', [
                'formData' => $formData,
                'errors' => $errors,
            ]);
        } else {
            $response = new Response();
            $response->setStatusCode(404);

            return $response;
        }
    }
}