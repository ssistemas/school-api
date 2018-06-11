<?php

namespace Emtudo\Units\Settings\Http\Controllers;

use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\Settings\Http\Requests\DocumentRequest;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function updateUser($userId, DocumentRequest $request, UserRepository $repository)
    {
        if (!$request->hasFile('document')) {
            return $this->respond->error('Você precisa enviar um arquivo');
        }

        if (!$request->file('document')->isValid()) {
            return $this->respond->notFound('Arquivo inválido!');
        }

        $user = $repository->findByPublicId($userId);
        if (!$user) {
            return $this->respond->notFound('Usuário não encotnrado');
        }

        $extension = $request->document->extension();
        $kind = $request->get('kind');
        $filename = $kind.'.'.$extension;

        $fileExists = $user->documents[$kind] ?? '';

        if ($fileExists) {
            @storage_file_delete('documents', $fileExists);
        }

        $path = Storage::disk('documents')->putFileAs(
            $user->id,
            $request->file('document'),
            $filename
        );

        $documents = array_merge($user->documents ?? [], [
            $kind => $filename,
        ]);

        $user->documents = $documents;
        $user->save();

        @storage_file_delete('documents', $filename);

        return $this->respond->ok($user, 'Arquivo salvo com sucesso');
    }

    public function update(DocumentRequest $request, UserRepository $repository)
    {
        return $this->updateUser($this->user->publicId(), $request, $repository);
    }

    public function destroy($kind)
    {
        $user = $this->user;
        $documents = array_merge(
            $user->documents ?? [],
            [$kind => null]
        );
        $user->deleteDocumentByKind($kind);
        $user->documents = $documents;
        $user->save();

        return $this->respond->ok($user);
    }

    public function getDocumetByKind($kind, UserRepository $repository)
    {
        $document = $this->user->getBase64DocumentByKind($kind);

        return $this->respond->ok($document);
    }
}
