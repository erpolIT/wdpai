<?php

use controllers\AppController;
use middlewares\AuthMiddleware;

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ProjectRepository.php';
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';

class DashboardController extends AppController {

    /**
     * @var ProjectRepository
     */

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['dashboard']));
        $this->layout = 'main';
    }

    public function dashboard() {
        return $this->renderView('dashboard', [
            "title" => "PROJECTS | WDPAI",
            //"items" => $this->projectRepository->getProjects()
            'userId' => Application::getUserId()
        ]);
    }

}