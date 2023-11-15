<?php

namespace App\Repositories;

use App\Interface\NoteRepositoryInterface;
use App\Models\Note;

class NoteRepository implements NoteRepositoryInterface
{
    protected $model;

    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    public function getUserNotes($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $noteId)
    {
        $note = $this->model->findOrFail($noteId);
        $note->update($data);
        return $note;
    }

    public function delete($noteId)
    {
        return $this->model->destroy($noteId);
    }
}
