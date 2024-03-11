<?php

namespace App\Interfaces;

interface IProjectRepository
{
    public function getAllProjects();

    public function getProjectById();

    public function getProjectByName();

    public function storeProject();
}
