<?php

namespace App\Repositories\Contracts;

interface PhaseRepositoryInterface
{
    public function getPhases();
    public function getStagesSelect($id);
    public function getStagesByPhase($phase_id);
}

