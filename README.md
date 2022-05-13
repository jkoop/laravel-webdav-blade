# Laravel WebDAV Blade

The WebDAV spec is a dumpster fire. Use this blade file (and example supporting files) to make your life easier.

Tested with Laravel v9.12.2.

## Usage

I tried my best to make the supporting files as self-explanatory as possible. Please feel free to read them.

## Some notes

+ WebDAV uses the PROPFIND method to get information about a file or folder. It is a kind of POST request (with a body), but I'm ignoring it here because I can. The request body just specifies what properties to return; we just assume they want everything.
+ PROPFINDs must respond with a 207 Multi-Status response, or 401, 403, 404, etc.
+ Before making a PROPFIND request, the client will make an OPTIONS request to determine if the server supports WebDAV.
+ Headers are picky! You can't `return` from a Controller or Laravel will add headers like Cookie, etc. Instead, you must `exit()`.