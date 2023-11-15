<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    protected $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function index()
    {
        $userId = Auth::id();
        $userNotes = $this->noteRepository->getUserNotes($userId);
        return view('notes.index')-> with([
            'userNotes'=>$userNotes
        ]);
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(NoteRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $this->noteRepository->create($data);
        return redirect()->route('notes.index');
    }

    public function show($id)
    {
        // Ensure the user owns the notes
        $note=Note::query()->where('id',$id)->first();

        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.show', compact('note'));
    }

    public function edit($id)
    {
        // Ensure the user owns the notes
        $note=Note::query()->where('id',$id)->first();
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    public function update(NoteRequest $request, $id)
    {
        // Ensure the user owns the notes
        $note=Note::query()->where('id',$id)->first();
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();
        $this->noteRepository->update($data, $note->id);
        return redirect()->route('notes.index');
    }

    public function destroy($id)
    {
        // Ensure the user owns the notes
        $note=Note::query()->where('id',$id)->first();
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $this->noteRepository->delete($note->id);
        return redirect('notes');
    }
}
