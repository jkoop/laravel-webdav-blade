{{-- documentation is README.md at https://github.com/jkoop/laravel-webdav-blade --}}
{{-- yes, the indentation must be this bad... --}}
<?xml version="1.0" encoding="utf-8"?>
<D:multistatus xmlns:D="DAV:">
@foreach ($files as $file)
<D:response xmlns:lp1="DAV:" xmlns:lp2="http://apache.org/dav/props/">
<D:href>/{{ trim($file['path'] ?? throw new \Exception('$file["path"] must be set'), '/') }}{{ $file['type'] == 'dir' ? '/' : '' }}</D:href> {{-- full path --}}
<D:propstat>
<D:prop>
@if ($file['type'] == 'dir')
<lp1:resourcetype><D:collection/></lp1:resourcetype>
@else
<lp1:resourcetype/>
@endif
@if ($file['creationDate'] ?? null instanceof \DateTime)
<lp1:creationdate>{{ $file['creationDate']->format(\DateTimeInterface::ISO8601) }}</lp1:creationdate> {{-- ISO 8601 --}}
@endif
@if ($file['type'] != 'dir' && isset($file['size']))
<lp1:getcontentlength>{{ max(0, (int) $file['size']) }}</lp1:getcontentlength>
@endif
@if ($file['lastModifiedDate'] ?? null instanceof \DateTime)
<lp1:getlastmodified>{{ $file['creationDate']->format(\DateTimeInterface::RFC2822) }}</lp1:getlastmodified> {{-- RFC 2822 --}}
@endif
@if (isset($file['etag']))
<lp1:getetag>"{{ $file['etag'] }}"</lp1:getetag>
@else
<lp1:getetag>"{{ md5(json_encode($file)) }}"</lp1:getetag> {{-- we should probs just use the hash of all the given metadata --}}
@endif
@if ($file['type'] != 'dir' && isset($file['executable']))
<lp2:executable>{{ $file['executable'] ? 'T' : 'F' }}</lp2:executable> {{-- T or F --}}
@endif
{{-- <D:supportedlock> // we don't support locking
<D:lockentry>
<D:lockscope><D:exclusive/></D:lockscope>
<D:locktype><D:write/></D:locktype>
</D:lockentry>
<D:lockentry>
<D:lockscope><D:shared/></D:lockscope>
<D:locktype><D:write/></D:locktype>
</D:lockentry>
</D:supportedlock> --}}
@if ($file['type'] == 'dir')
<D:getcontenttype>httpd/unix-directory</D:getcontenttype> {{-- httpd/unix-directory for directory, else use mimetype --}}
@elseif (isset($file['mimeType']))
<D:getcontenttype>{{ $file['mimeType'] }}</D:getcontenttype>
@else
<D:getcontenttype>application/octet-stream</D:getcontenttype>
@endif
</D:prop>
<D:status>HTTP/1.1 {{ ($file['readable'] ?? true) '200 OK' : '403 Forbidden' }}</D:status> {{-- 200 OK (or maybe 403 Forbidden); not every client is attentive --}}
</D:propstat>
</D:response>
@endforeach
</D:multistatus>
