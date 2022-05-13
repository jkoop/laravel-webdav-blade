<?php

namespace App\Http\Controllers;

use DateTime;

class WebDavController extends Controller {
    public function options() {
        header('allow: OPTIONS,PROPFIND');
        header('content-type: httpd/unix-directory');
        header('dav: 1,2');
        header('vary: Origin');
        exit;
    }
    public function propfind() {
        $files = [
            // a representative of the requested path must included in the response
            [
                // path is required; will be prepended with a slash if needed, dirs will automatically be appended with a slash if needed; default `throw new Exception`
                'path' => request()->path(),

                // type is required and must be either 'dir' or 'file'; default 'file'
                'type' => 'dir',

                // creation date is optional and must be a DateTime* instance; default missing
                'creationDate' => new DateTime('1970-01-01 0:00:00 UTC'),

                // last modified date is optional and must be a DateTime* instance; default missing
                'lastModifiedDate' => new DateTime('1970-01-01 0:00:00 UTC'),

                // size in bytes is optional and must be an integer; ignored for dirs; default missing
                'size' => 0,

                // etag is optional and must be a string; will be automatically surrounded by quotes; default md5 of all properties
                'etag' => md5(request()->path()),

                // executable is optional and must be a boolean; ignored for dirs; default missing
                'executable' => false,

                // mime type is optional and must be a string; value will be 'application/x-directory' for dirs; default 'application/octet-stream' for files
                'mimeType' => 'application/x-directory',

                // readable is optional and must be a boolean; default true
                'readable' => true,
            ],
            [
                'path' => '/hello-there.txt',
                'type' => 'file',
                'size' => 0,
            ],
        ];

        header('HTTP/1.1 207 Multi-Status');
        header('Content-Type: text/xml');
        header('Vary: Origin');
        echo view('webdav', compact('files'))->render();
        exit;
    }
}
