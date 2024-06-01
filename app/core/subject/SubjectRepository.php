<?php
namespace App\core\subject;

use App\Models\Subject;

class SubjectRepository implements SubjectInterface {
    public function getAllSubjects(){
        return Subject::orderBy('id', 'asc')->get();
    }
}