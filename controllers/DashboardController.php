<?php
declare(strict_types=1);

class DashboardController extends Controller
{

    public function index(): void
    {
        $this->requireAuth();
        $this->render('dashboard/index', [], 'none');
    }
}
