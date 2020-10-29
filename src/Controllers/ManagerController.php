<?php

namespace MasterDmx\LaravelMediaManager\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use MasterDmx\LaravelMedia\MediaHelper;
use MasterDmx\LaravelMedia\MediaManager;
use MasterDmx\LaravelMedia\Models\Media;
use MasterDmx\LaravelMedia\Services\Uploader;
use Storage;

class ManagerController
{
    /**
     * Медиа менеджер
     *
     * @var \MasterDmx\LaravelMedia\MediaManager
     */
    private $manager;

    public function __construct(MediaManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Инициализация
     */
    public function init(Request $request)
    {
        return [
            'allow_extensions' => config('media.allow_extensions'),
            'storage_url' => $this->manager->getStorage()->url(''),
            'user_mode' => config('media.user_mode'),
        ];
    }

    /**
     * Загрузка файлов
     */
    public function files(Request $request)
    {
        return $this->manager->getModel()->orderBy('id', 'DESC')->get()->each(function ($model) {
            $model->defineUrl();
        });
    }

    /**
     * Загрузка файла
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'mimes:' . implode(',', config('media.allow_extensions'))
            ]
        ]);

        try {
            return $this->manager->addFile($request->file('file'))->defineUrl();
        } catch (Exception $th) {
            return response(['status' => 'error'], 400);
        }
    }

    public function remove($id)
    {
        if ($media = $this->manager->getModel()->find($id)) {
            $media->delete();

            return response(['status' => 'success'], 200);
        }

        return response(['status' => 'file_not_found'], 404);
    }

}
