<?php

namespace App\Interface;

interface NoteRepositoryInterface
{
    public function getUserNotes($userId);
    public function create(array $data);
    public function update(array $data, $noteId);
    public function delete($noteId);
}
