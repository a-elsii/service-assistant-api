<?php
namespace serviceAssistant\extraServices;

use serviceAssistant\helper\serviceAssistantApiHelper;

trait serviceAssistantApiTodo
{
    protected $urlGetAllTodoList = 'todo-list';
    protected $urlCreate = 'todo-list/create';
    protected $urlClose = 'todo-list/close';

    /**
     * Function for get all items
     *
     * @return array|false|mixed
     */
    public function getAllTodoList()
    {
        return $this->serviceAssistant->sendRequest($this->urlGetAllTodoList);
    }

    /**
     * Function for create item
     *
     * @param string $title
     * @return array|false|mixed
     */
    public function createTodoItem(
        string $title
    )
    {
        return $this->serviceAssistant->sendRequest($this->urlCreate, [
            'title' => $title,
        ], serviceAssistantApiHelper::API_METHOD_POST);
    }

    /**
     * Function for delete item
     *
     * @param string $id
     * @return array|false|mixed
     */
    public function closeTodoItem(
        string $id
    )
    {
        return $this->serviceAssistant->sendRequest($this->urlClose, [
            'id_task' => $id,
        ], serviceAssistantApiHelper::API_METHOD_POST);
    }
}
