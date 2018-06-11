<?php

namespace Emtudo\Units\Files\Http\Controllers;

use Emtudo\Domains\Files\Contracts\FileRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\Files\Http\Requests\UploadTemporaryRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileController extends Controller
{
    /**
     * @var \Emtudo\Support\Files\GroupManager
     */
    protected $groupManager;

    /**
     * Receives temporary files.
     *
     * @param UploadTemporaryRequest $request
     * @param FileRepository         $repository
     *
     * @return \Illuminate\Http\JsonResponse|\Spatie\Fractal\Fractal
     */
    public function temporary(UploadTemporaryRequest $request, FileRepository $repository)
    {
        //try { // try to upload the files.
        $file = $repository->createTemporary($request->file('file'), $request->get('kind'));
        // returns the transformed uploaded file.
        // return $file->getRelativePath();
        return $repository->transformItem($file);
    }

    /**
     * Search file.
     *
     * @param $uuid
     * @param FileRepository $repository
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function show($uuid, FileRepository $repository)
    {
        $file = $repository->findByUUID($uuid);

        if ($file) {
            return $repository->transformItem($file);
        }

        throw new NotFoundHttpException('Arquivo não encontrado.');
    }

    public function download($uuid, FileRepository $repository)
    {
        $file = $repository->findByUUID($uuid);

        if ($file) {
            $data = $file->getInstance();

            if (!$data) {
                abort(404, __('Não foi possível localizar o arquivo..'));
            }

            return response($data, 200)
                ->header('Content-Type', $file->mime)
                ->header('Content-Disposition', 'attachment; filename="'.$file->label.'"');
        }
    }
}
