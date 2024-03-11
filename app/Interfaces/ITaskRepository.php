<?php

namespace App\Interfaces;

interface ITaskRepository
{
    public function getAllTasks();

    public function getTaskById();

    public function getTasksByProject();

    public function getTasksByAssigner();

    public function getTaskByName();

    public function getTasksByPriority();

    public function getTasksByStatus();
}
