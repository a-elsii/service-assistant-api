<?php
namespace serviceAssistant;

use serviceAssistant\Helper\serviceAssistantApiHelper;

class serviceAssistantApiTodo extends serviceAssistantApi
{
    const URL_GET_ALL = 'todo-list';
    const URL_CREATE = 'todo-list/create';
    const URL_CLOSE = 'todo-list/close';

    /**
     * Function for get all items
     *
     * @return array|false|mixed
     */
    public function getAll()
    {
        return $this->serviceAssistant->sendRequest(self::URL_GET_ALL);
    }

    /**
     * Function for create item
     *
     * @param string $title
     * @return array|false|mixed
     */
    public function create(
        string $title
    )
    {
        return $this->serviceAssistant->sendRequest(self::URL_CREATE, [
            'title' => $title,
        ], serviceAssistantApiHelper::API_METHOD_POST);
    }

    /**
     * Function for delete item
     *
     * @param string $id
     * @return array|false|mixed
     */
    public function close(
        string $id
    )
    {
        return $this->serviceAssistant->sendRequest(self::URL_CLOSE, [
            'id_task' => $id,
        ], serviceAssistantApiHelper::API_METHOD_POST);
    }
}
