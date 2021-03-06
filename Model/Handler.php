<?php


class Handler
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = $this->openConnection();

    }

    public function openConnection(): PDO
    {
        require 'config.php';

        return new PDO('mysql:host=' . $dbhost . ';dbname=' . $db, $dbuser, $dbpass, $driverOptions);
    }

    public function getStudent($id)
    {
        $handle = $this->pdo->prepare('SELECT * FROM students WHERE id = :id');
        $handle->bindValue(':id', $id);
        $handle->execute();
        return $handle->fetchAll();
    }

    public function getStudents()
    {
        $handle = $this->pdo->prepare('SELECT * FROM students');
        $handle->execute();
        return $handle->fetchAll();
    }

    public function getTeachers()
    {
        $handle = $this->pdo->prepare('SELECT * FROM teachers');
        $handle->execute();
        return $handle->fetchAll();
    }

    public function getTeacher($id)
    {
        $handle = $this->pdo->prepare('SELECT * FROM teachers WHERE id = :id');
        $handle->bindValue(':id', $id);
        $handle->execute();
        return $handle->fetchAll();
    }

    public function getClass($id)
    {
        $handle = $this->pdo->prepare('SELECT * FROM classes WHERE id = :id');
        $handle->bindValue(':id', $id);
        $handle->execute();
        return $handle->fetchAll();
    }

    public function getClasses()
    {
        $handle = $this->pdo->prepare('SELECT * FROM classes');
        $handle->execute();
        return $handle->fetchAll();
    }

    public function addTeacher($name, $email, $classesId)
    {
        $handle = $this->pdo->prepare('INSERT INTO teachers (name, email,classes_id) VALUES (:name,:email,:classes_id )');
        $handle->bindValue(':name', $name);
        $handle->bindValue(':email', $email);
        $handle->bindValue(':classes_id', $classesId);
        $handle->execute();
    }


    public function addStudent($name, $email, $classes_id)
    {
        $handle = $this->pdo->prepare('INSERT INTO students ( name, email,classes_id) VALUES (:name,:email,:classes_id )');
        $handle->bindValue(':name', $name);
        $handle->bindValue(':email', $email);
        $handle->bindValue(':classes_id', $classes_id);
        $handle->execute();
    }

    public function updateTeacher($id, $name, $email, $classesId)
    {
        $handle = $this->pdo->prepare('UPDATE teachers SET name =:name, email =:email, classes_id = :classes_id WHERE id = :id');
        $handle->bindValue(':id', $id);
        $handle->bindValue(':name', $name);
        $handle->bindValue(':email', $email);
        $handle->bindValue(':classes_id', $classesId);
        $handle->execute();
    }

    public function updateStudent($id, $name, $email, $classes_id)
    {
        $handle = $this->pdo->prepare('UPDATE students SET name =:name, email =:email, classes_id = :classes_id WHERE id = :id');
        $handle->bindValue(':id', $id);
        $handle->bindValue(':name', $name);
        $handle->bindValue(':email', $email);
        $handle->bindValue(':classes_id', $classes_id);
        $handle->execute();
    }

    public function updateClasses($id, $name, $location)
    {
        $handle = $this->pdo->prepare('UPDATE classes SET name =:name, location =:location WHERE id = :id');
        $handle->bindValue(':id', $id);
        $handle->bindValue(':name', $name);
        $handle->bindValue(':location', $location);
        $handle->execute();
    }

    function getStudentsCourse($teacherCourse)
    {
        $students = $this->getStudents();
        $teacherStudents = array();
        foreach ($students as $student) {
            if ($student['classes_id'] == $teacherCourse) {
                array_push($teacherStudents, $student);
            }
        }
        return $teacherStudents;
    }

    function getTeacherCourse($classid){

        $teachers = $this->getTeachers();
        foreach($teachers as $teacher){
            if($teacher['classes_id'] == $classid ){
                return $teacher;
            }
        }
    }


    function deleteTeacher($teacherId)
    {
        $teachers =  $this->getTeachers();
        foreach ($teachers as $teacher) {
            if ($teacher['id'] == $teacherId) {
                $handle = $this->pdo->prepare('DELETE FROM teachers WHERE id = :id');
                $handle->bindValue(':id', $teacherId);
                $handle->execute();
            }
        }

    }

    function deleteStudent($studentId)
    {
        $students = $this->getStudents();
        foreach ($students as $student) {
            if ($student['id'] == $studentId) {
                $handle = $this->pdo->prepare('DELETE FROM students WHERE id = :id;');
                $handle->bindValue(':id', $studentId);
                $handle->execute();
            }
        }

    }

    function deleteClass($classId)
    {
        $classes = $this->getClasses();
        foreach ( $classes as $class) {
            if ($class['id'] == $classId) {
                $handle = $this->pdo->prepare('DELETE FROM classes WHERE id = :id;');
                $handle->bindValue(':id', $classId);
                $handle->execute();
            }
        }

    }

    function getClassName($classId)
    {
        $classes = $this->getClasses();
        foreach ( $classes as $class) {
            if ($class['id'] == $classId) {
                return $class['name'];
            }
        }

    }

    function getClassId($className)
    {
        $classes = $this->getClasses();
        foreach ( $classes as $class) {
            if ($class['name'] == $className) {
                return $class['id'];
            }
        }

    }

    function getTeacherFromCourse($name){

        $teachers = $this->getTeachers();
        $classid =  $this->getClassId($name);
        foreach($teachers as $teacher){
            if($teacher['classes_id'] == $classid ){
                return $teacher['name'];
            }
        }
    }

    public function addClass($name, $location)
    {
        $handle = $this->pdo->prepare('INSERT INTO classes (name,location) VALUES (:name,:location )');
        $handle->bindValue(':name', $name);
        $handle->bindValue(':location', $location);
        $handle->execute();
    }



}