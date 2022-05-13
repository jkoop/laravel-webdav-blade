# Laravel WebDAV Blade

The WebDAV spec is a dumpster fire. Use this blade file to make your life easier.

## Usage

Example (tested with Laravel 9.x):

```php
$files = [
    // a representative of the requested path must included in the response
    {
        // path is required; will be prepended with a slash if needed, dirs will automatically be appended with a slash if needed; default `throw new Exception`
        'path' => url()->current(),

        // type is required and must be either 'dir' or 'file'; default 'file'
        'type' => 'dir',

        // creation date is optional and must be a DateTime* instance; default missing
        'creationDate' => new DateTime('1970-01-01 0:00:00 UTC'),

        // last modified date is optional and must be a DateTime* instance; default missing
        'lastModifiedDate' => new DateTime('1970-01-01 0:00:00 UTC'),

        // size in bytes is optional and must be an integer; ignored for dirs; default missing
        'size' => 0,

        // etag is optional and must be a string; will be automatically surrounded by quotes; default md5 of all properties
        'etag' => md5(url()->current()),

        // executable is optional and must be a boolean; ignored for dirs; default missing
        'executable' => false,

        // mime type is optional and must be a string; value will be 'application/x-directory' for dirs; default 'application/octet-stream' for files
        'mimeType' => 'application/x-directory',

        // readable is optional and must be a boolean; default true
        'readable' => true,
    },
    ...
];

return view('path/to/webdav', [
    'files' => $files,
], 207)
    ->header('Content-Type', 'text/xml');
```

\* DateTime includes Carbon