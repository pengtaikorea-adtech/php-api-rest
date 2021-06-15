<?php namespace ApiRest;

class cURL {
	/** OPTIONS 
	 * : auto generated via https://www.php.net/manual/en/function.curl-setopt.php  
	 * : with script ../scripts/curlopt.generate.js
	 * **/
	const OPTIONS = [
		/* true to automatically set the Referer: field in requests where it follows a Location: redirect. */
		'autoreferer' => 'bool',
		/* true to mark this as a new cookie "session". It will force libcurl to ignore all cookies it is about to load that are "session cookies" from the previous session. By default, libcurl always stores and loads all cookies, independent if they are session cookies or not. Session cookies are cookies without expiry date and they are meant to be alive and existing for this "session" only. */
		'cookiesession' => 'bool',
		/* true to output SSL certification information to STDERR on secure transfers. */
		'certinfo' => 'bool',	// cURL v7.19.1.
		/* true tells the library to perform all the required proxy authentication and connection setup, but no data transfer. This option is implemented for HTTP, SMTP and POP3. */
		'connect_only' => 'bool',
		/* true to convert Unix newlines to CRLF newlines on transfers. */
		'crlf' => 'bool',
		/* true to not allow URLs that include a username. Usernames are allowed by default (0). */
		'disallow_username_in_url' => 'bool',	// cURL v7.61.0.php 7.3.0.
		/* true to shuffle the order of all returned addresses so that they will be used in a random order, when a name is resolved and more than one IP address is returned. This may cause IPv4 to be used before IPv6 or vice versa. */
		'dns_shuffle_addresses' => 'bool',	// cURL v7.60.0.php 7.3.0.
		/* true to send an HAProxy PROXY protocol v1 header at the start of the connection. The default action is not to send this header. */
		'haproxyprotocol' => 'bool',	// cURL v7.60.0.php 7.3.0.
		/* true to enable built-in SSH compression. This is a request, not an order; the server may or may not do it. */
		'ssh_compression' => 'bool',	// cURL v7.56.0.php 7.3.0.
		/* true to use a global DNS cache. This option is not thread-safe. It is conditionally enabled by default if PHP is built for non-threaded use (CLI, FCGI, Apache2-Prefork, etc.). */
		'dns_use_global_cache' => 'bool',
		/* true to fail verbosely if the HTTP code returned is greater than or equal to 400. The default behavior is to return the page normally, ignoring the code. */
		'failonerror' => 'bool',
		/* true to enable TLS false start. */
		'ssl_falsestart' => 'bool',	// cURL v7.42.0.php 7.0.7.
		/* true to attempt to retrieve the modification date of the remote document. This value can be retrieved using the CURLINFO_FILETIME option with curl_getinfo(). */
		'filetime' => 'bool',
		/* true to follow any "Location: " header that the server sends as part of the HTTP header. See also CURLOPT_MAXREDIRS. */
		'followlocation' => 'bool',
		/* true to force the connection to explicitly close when it has finished processing, and not be pooled for reuse. */
		'forbid_reuse' => 'bool',
		/* true to force the use of a new connection instead of a cached one. */
		'fresh_connect' => 'bool',
		/* true to use EPRT (and LPRT) when doing active FTP downloads. Use false to disable EPRT and LPRT and use PORT only. */
		'ftp_use_eprt' => 'bool',
		/* true to first try an EPSV command for FTP transfers before reverting back to PASV. Set to false to disable EPSV. */
		'ftp_use_epsv' => 'bool',
		/* true to create missing directories when an FTP operation encounters a path that currently doesn't exist. */
		'ftp_create_missing_dirs' => 'bool',
		/* true to append to the remote file instead of overwriting it. */
		'ftpappend' => 'bool',
		/* true to disable TCP's Nagle algorithm, which tries to minimize the number of small packets on the network. */
		'tcp_nodelay' => 'bool',	// cURL v7.11.2
		/* An alias of CURLOPT_TRANSFERTEXT. Use that instead. */
		'ftpascii' => 'bool',
		/* true to only list the names of an FTP directory. */
		'ftplistonly' => 'bool',
		/* true to include the header in the output. */
		'header' => 'bool',
		/* true to track the handle's request string. */
		'curlinfo_header_out' => 'bool',
		/* Whether to allow HTTP/0.9 responses. Defaults to false as of libcurl 7.66.0; formerly it defaulted to true. */
		'http09_allowed' => 'bool',	// php 7.3.15
		/* true to reset the HTTP request method to GET. Since GET is the default, this is only necessary if the request method has been changed. */
		'httpget' => 'bool',
		/* true to tunnel through a given HTTP proxy. */
		'httpproxytunnel' => 'bool',
		/* false to get the raw HTTP response body. */
		'http_content_decoding' => 'bool',
		/* true to keep sending the request body if the HTTP code returned is equal to or larger than 300. The default action would be to stop sending and close the stream or connection. Suitable for manual NTLM authentication. Most applications do not need this option. */
		'keep_sending_on_error' => 'bool',	// php 7.3.0
		/* true to be completely silent with regards to the cURL functions. */
		'mute' => 'bool',	// cURL v7.15.5
		/* true to scan the ~/.netrc file to find a username and password for the remote site that a connection is being established with. */
		'netrc' => 'bool',
		/* true to exclude the body from the output. Request method is then set to HEAD. Changing this to false does not change it to GET. */
		'nobody' => 'bool',
		/* true to disable the progress meter for cURL transfers. Note: PHP automatically sets this option to true, this should only be changed for debugging purposes. */
		'noprogress' => 'bool',
		/* true to ignore any cURL function that causes a signal to be sent to the PHP process. This is turned on by default in multi-threaded SAPIs so timeout options can still be used. */
		'nosignal' => 'bool',	// cURL v7.10.
		/* true to not handle dot dot sequences. */
		'path_as_is' => 'bool',	// cURL v7.42.0.php 7.0.7.
		/* true to wait for pipelining/multiplexing. */
		'pipewait' => 'bool',	// cURL v7.43.0.php 7.0.7.
		/* true to do a regular HTTP POST. This POST is the normal application/x-www-form-urlencoded kind, most commonly used by HTML forms. */
		'post' => 'bool',
		/* true to HTTP PUT a file. The file to PUT must be set with CURLOPT_INFILE and CURLOPT_INFILESIZE. */
		'put' => 'bool',
		/* true to return the transfer as a string of the return value of curl_exec() instead of outputting it directly. */
		'returntransfer' => 'bool',
		/* true to enable sending the initial response in the first packet. */
		'sasl_ir' => 'bool',	// cURL v7.31.10.php 7.0.7.
		/* false to disable ALPN in the SSL handshake (if the SSL backend libcurl is built to use supports it), which can be used to negotiate http2. */
		'ssl_enable_alpn' => 'bool',	// cURL v7.36.0.php 7.0.7.
		/* false to disable NPN in the SSL handshake (if the SSL backend libcurl is built to use supports it), which can be used to negotiate http2. */
		'ssl_enable_npn' => 'bool',	// cURL v7.36.0.php 7.0.7.
		/* false to stop cURL from verifying the peer's certificate. Alternate certificates to verify against can be specified with the CURLOPT_CAINFO option or a certificate directory can be specified with the CURLOPT_CAPATH option. */
		'ssl_verifypeer' => 'bool',	// cURL v7.10.
		/* true to verify the certificate's status. */
		'ssl_verifystatus' => 'bool',	// cURL v7.41.0.php 7.0.7.
		/* false to stop cURL from verifying the peer's certificate. Alternate certificates to verify against can be specified with the CURLOPT_CAINFO option or a certificate directory can be specified with the CURLOPT_CAPATH option. When set to false, the peer certificate verification succeeds regardless. */
		'proxy_ssl_verifypeer' => 'bool',	// cURL v7.52.0.php 7.3.0
		/* true to suppress proxy CONNECT response headers from the user callback functions CURLOPT_HEADERFUNCTION and CURLOPT_WRITEFUNCTION, when CURLOPT_HTTPPROXYTUNNEL is used and a CONNECT request is made. */
		'suppress_connect_headers' => 'bool',	// cURL v7.54.0.php 7.3.0.
		/* true to enable TCP Fast Open. */
		'tcp_fastopen' => 'bool',	// cURL v7.49.0.php 7.0.7.
		/* true to not send TFTP options requests. */
		'tftp_no_options' => 'bool',	// cURL v7.48.0.php 7.0.7.
		/* true to use ASCII mode for FTP transfers. For LDAP, it retrieves data in plain text instead of HTML. On Windows systems, it will not set STDOUT to binary mode. */
		'transfertext' => 'bool',
		/* true to keep sending the username and password when following locations (using CURLOPT_FOLLOWLOCATION), even when the hostname has changed. */
		'unrestricted_auth' => 'bool',
		/* true to prepare for an upload. */
		'upload' => 'bool',
		/* true to output verbose information. Writes output to STDERR, or the file specified using CURLOPT_STDERR. */
		'verbose' => 'bool',
		/* The size of the buffer to use for each read. There is no guarantee this request will be fulfilled, however. */
		'buffersize' => 'integer',	// cURL v7.10.
		/* The number of seconds to wait while trying to connect. Use 0 to wait indefinitely. */
		'connecttimeout' => 'integer',
		/* The number of milliseconds to wait while trying to connect. Use 0 to wait indefinitely. If libcurl is built to use the standard system name resolver, that portion of the connect will still use full-second resolution for timeouts with a minimum timeout allowed of one second. */
		'connecttimeout_ms' => 'integer',	// cURL v7.16.2.
		/* The number of seconds to keep DNS entries in memory. This option is set to 120 (2 minutes) by default. */
		'dns_cache_timeout' => 'integer',
		/* The timeout for Expect: 100-continue responses in milliseconds. Defaults to 1000 milliseconds. */
		'expect_100_timeout_ms' => 'integer',	// cURL v7.36.0.php 7.0.7.
		/* Head start for ipv6 for the happy eyeballs algorithm. Happy eyeballs attempts to connect to both IPv4 and IPv6 addresses for dual-stack hosts, preferring IPv6 first for timeout milliseconds. Defaults to CURL_HET_DEFAULT, which is currently 200 milliseconds. */
		'happy_eyeballs_timeout_ms' => 'integer',	// cURL v7.59.0.php 7.3.0.
		/* The FTP authentication method (when is activated): CURLFTPAUTH_SSL (try SSL first), CURLFTPAUTH_TLS (try TLS first), or CURLFTPAUTH_DEFAULT (let cURL decide). */
		'ftpsslauth' => 'integer',	// cURL v7.12.2.
		/* How to deal with headers. One of the following constants: CURLHEADER_UNIFIED: the headers specified in CURLOPT_HTTPHEADER will be used in requests both to servers and proxies. With this option enabled, CURLOPT_PROXYHEADER will not have any effect. CURLHEADER_SEPARATE: makes CURLOPT_HTTPHEADER headers only get sent to a server and not to a proxy. Proxy headers must be set with CURLOPT_PROXYHEADER to get used. Note that if a non-CONNECT request is sent to a proxy, libcurl will send both server headers and proxy headers. When doing CONNECT, libcurl will send CURLOPT_PROXYHEADER headers only to the proxy and then CURLOPT_HTTPHEADER headers only to the server. Defaults to CURLHEADER_SEPARATE as of cURL 7.42.1, and CURLHEADER_UNIFIED before. */
		'headeropt' => 'integer',	// cURL v7.37.0.php 7.0.7.
		/* CURL_HTTP_VERSION_NONE (default, lets CURL decide which version to use), CURL_HTTP_VERSION_1_0 (forces HTTP/1.0), CURL_HTTP_VERSION_1_1 (forces HTTP/1.1), CURL_HTTP_VERSION_2_0 (attempts HTTP 2), CURL_HTTP_VERSION_2 (alias of CURL_HTTP_VERSION_2_0), CURL_HTTP_VERSION_2TLS (attempts HTTP 2 over TLS (HTTPS) only) or CURL_HTTP_VERSION_2_PRIOR_KNOWLEDGE (issues non-TLS HTTP requests using HTTP/2 without HTTP/1.1 Upgrade). */
		'http_version' => 'integer',
		/* The HTTP authentication method(s) to use. The options are: CURLAUTH_BASIC, CURLAUTH_DIGEST, CURLAUTH_GSSNEGOTIATE, CURLAUTH_NTLM, CURLAUTH_ANY, and CURLAUTH_ANYSAFE. The bitwise | (or) operator can be used to combine more than one method. If this is done, cURL will poll the server to see what methods it supports and pick the best one. CURLAUTH_ANY is an alias for CURLAUTH_BASIC | CURLAUTH_DIGEST | CURLAUTH_GSSNEGOTIATE | CURLAUTH_NTLM. CURLAUTH_ANYSAFE is an alias for CURLAUTH_DIGEST | CURLAUTH_GSSNEGOTIATE | CURLAUTH_NTLM. */
		'httpauth' => 'integer',
		/* The expected size, in bytes, of the file when uploading a file to a remote site. Note that using this option will not stop libcurl from sending more data, as exactly what is sent depends on CURLOPT_READFUNCTION. */
		'infilesize' => 'integer',
		/* The transfer speed, in bytes per second, that the transfer should be below during the count of CURLOPT_LOW_SPEED_TIME seconds before PHP considers the transfer too slow and aborts. */
		'low_speed_limit' => 'integer',
		/* The number of seconds the transfer speed should be below CURLOPT_LOW_SPEED_LIMIT before PHP considers the transfer too slow and aborts. */
		'low_speed_time' => 'integer',
		/* The maximum amount of persistent connections that are allowed. When the limit is reached, CURLOPT_CLOSEPOLICY is used to determine which connection to close. */
		'maxconnects' => 'integer',
		/* The maximum amount of HTTP redirections to follow. Use this option alongside CURLOPT_FOLLOWLOCATION. Default value of 20 is set to prevent infinite redirects. Setting to -1 allows inifinite redirects, and 0 refuses all redirects. */
		'maxredirs' => 'integer',
		/* An alternative port number to connect to. */
		'port' => 'integer',
		/* A bitmask of 1 (301 Moved Permanently), 2 (302 Found) and 4 (303 See Other) if the HTTP POST method should be maintained when CURLOPT_FOLLOWLOCATION is set and a specific type of redirect occurs. */
		'postredir' => 'integer',	// cURL v7.19.1.
		/* Bitmask of CURLPROTO_* values. If used, this bitmask limits what protocols libcurl may use in the transfer. This allows you to have a libcurl built to support a wide range of protocols but still limit specific transfers to only be allowed to use a subset of them. By default libcurl will accept all protocols it supports. See also CURLOPT_REDIR_PROTOCOLS. Valid protocol options are: CURLPROTO_HTTP, CURLPROTO_HTTPS, CURLPROTO_FTP, CURLPROTO_FTPS, CURLPROTO_SCP, CURLPROTO_SFTP, CURLPROTO_TELNET, CURLPROTO_LDAP, CURLPROTO_LDAPS, CURLPROTO_DICT, CURLPROTO_FILE, CURLPROTO_TFTP, CURLPROTO_ALL */
		'protocols' => 'integer',	// cURL v7.19.4.
		/* The HTTP authentication method(s) to use for the proxy connection. Use the same bitmasks as described in CURLOPT_HTTPAUTH. For proxy authentication, only CURLAUTH_BASIC and CURLAUTH_NTLM are currently supported. */
		'proxyauth' => 'integer',	// cURL v7.10.7.
		/* The port number of the proxy to connect to. This port number can also be set in CURLOPT_PROXY. */
		'proxyport' => 'integer',
		/* Either CURLPROXY_HTTP (default), CURLPROXY_SOCKS4, CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A or CURLPROXY_SOCKS5_HOSTNAME. */
		'proxytype' => 'integer',	// cURL v7.10.
		/* Bitmask of CURLPROTO_* values. If used, this bitmask limits what protocols libcurl may use in a transfer that it follows to in a redirect when CURLOPT_FOLLOWLOCATION is enabled. This allows you to limit specific transfers to only be allowed to use a subset of protocols in redirections. By default libcurl will allow all protocols except for FILE and SCP. This is a difference compared to pre-7.19.4 versions which unconditionally would follow to all protocols supported. See also CURLOPT_PROTOCOLS for protocol constant values. */
		'redir_protocols' => 'integer',	// cURL v7.19.4.
		/* The offset, in bytes, to resume a transfer from. */
		'resume_from' => 'integer',
		/* The SOCKS5 authentication method(s) to use. The options are: CURLAUTH_BASIC, CURLAUTH_GSSAPI, CURLAUTH_NONE. The bitwise | (or) operator can be used to combine more than one method. If this is done, cURL will poll the server to see what methods it supports and pick the best one. CURLAUTH_BASIC allows username/password authentication. CURLAUTH_GSSAPI allows GSS-API authentication. CURLAUTH_NONE allows no authentication. Defaults to CURLAUTH_BASIC|CURLAUTH_GSSAPI. Set the actual username and password with the CURLOPT_PROXYUSERPWD option. */
		'socks5_auth' => 'integer',
		/* Set SSL behavior options, which is a bitmask of any of the following constants: CURLSSLOPT_ALLOW_BEAST: do not attempt to use any workarounds for a security flaw in the SSL3 and TLS1.0 protocols. CURLSSLOPT_NO_REVOKE: disable certificate revocation checks for those SSL backends where such behavior is present. */
		'ssl_options' => 'integer',	// cURL v7.25.0.php 7.0.7.
		/* 1 to check the existence of a common name in the SSL peer certificate. 2 to check the existence of a common name and also verify that it matches the hostname provided. 0 to not check the names. In production environments the value of this option should be kept at 2 (default value). */
		'ssl_verifyhost' => 'integer',	// cURL v7.28.1.
		/* One of CURL_SSLVERSION_DEFAULT (0), CURL_SSLVERSION_TLSv1 (1), CURL_SSLVERSION_SSLv2 (2), CURL_SSLVERSION_SSLv3 (3), CURL_SSLVERSION_TLSv1_0 (4), CURL_SSLVERSION_TLSv1_1 (5) or CURL_SSLVERSION_TLSv1_2 (6). The maximum TLS version can be set by using one of the CURL_SSLVERSION_MAX_* constants. It is also possible to OR one of the CURL_SSLVERSION_* constants with one of the CURL_SSLVERSION_MAX_* constants. CURL_SSLVERSION_MAX_DEFAULT (the maximum version supported by the library), CURL_SSLVERSION_MAX_TLSv1_0, CURL_SSLVERSION_MAX_TLSv1_1, CURL_SSLVERSION_MAX_TLSv1_2, or CURL_SSLVERSION_MAX_TLSv1_3. Note: Your best bet is to not set this and let it use the default. Setting it to 2 or 3 is very dangerous given the known vulnerabilities in SSLv2 and SSLv3. */
		'sslversion' => 'integer',
		/* Set proxy SSL behavior options, which is a bitmask of any of the following constants: CURLSSLOPT_ALLOW_BEAST: do not attempt to use any workarounds for a security flaw in the SSL3 and TLS1.0 protocols. CURLSSLOPT_NO_REVOKE: disable certificate revocation checks for those SSL backends where such behavior is present. (curl >= 7.44.0) CURLSSLOPT_NO_PARTIALCHAIN: do not accept "partial" certificate chains, which it otherwise does by default. (curl >= 7.68.0) */
		'proxy_ssl_options' => 'integer',	// cURL v7.52.0.php 7.3.0
		/* Set to 2 to verify in the HTTPS proxy's certificate name fields against the proxy name. When set to 0 the connection succeeds regardless of the names used in the certificate. Use that ability with caution! 1 treated as a debug option in curl 7.28.0 and earlier. From curl 7.28.1 to 7.65.3 CURLE_BAD_FUNCTION_ARGUMENT is returned. From curl 7.66.0 onwards 1 and 2 is treated as the same value. In production environments the value of this option should be kept at 2 (default value). */
		'proxy_ssl_verifyhost' => 'integer',	// cURL v7.52.0.php 7.3.0
		/* One of CURL_SSLVERSION_DEFAULT, CURL_SSLVERSION_TLSv1, CURL_SSLVERSION_TLSv1_0, CURL_SSLVERSION_TLSv1_1, CURL_SSLVERSION_TLSv1_2, CURL_SSLVERSION_TLSv1_3, CURL_SSLVERSION_MAX_DEFAULT, CURL_SSLVERSION_MAX_TLSv1_0, CURL_SSLVERSION_MAX_TLSv1_1, CURL_SSLVERSION_MAX_TLSv1_2, CURL_SSLVERSION_MAX_TLSv1_3 or CURL_SSLVERSION_SSLv3. Note: Your best bet is to not set this and let it use the default CURL_SSLVERSION_DEFAULT which will attempt to figure out the remote SSL protocol version. */
		'proxy_sslversion' => 'integer',	// cURL v7.52.0.php 7.3.0
		/* Set the numerical stream weight (a number between 1 and 256). */
		'stream_weight' => 'integer',	// cURL v7.46.0.php 7.0.7.
		/* If set to 1, TCP keepalive probes will be sent. The delay and frequency of these probes can be controlled by the CURLOPT_TCP_KEEPIDLE and CURLOPT_TCP_KEEPINTVL options, provided the operating system supports them. If set to 0 (default) keepalive probes are disabled. */
		'tcp_keepalive' => 'integer',	// cURL v7.25.0.
		/* Sets the delay, in seconds, that the operating system will wait while the connection is idle before sending keepalive probes, if CURLOPT_TCP_KEEPALIVE is enabled. Not all operating systems support this option. The default is 60. */
		'tcp_keepidle' => 'integer',	// cURL v7.25.0.
		/* Sets the interval, in seconds, that the operating system will wait between sending keepalive probes, if CURLOPT_TCP_KEEPALIVE is enabled. Not all operating systems support this option. The default is 60. */
		'tcp_keepintvl' => 'integer',	// cURL v7.25.0.
		/* How CURLOPT_TIMEVALUE is treated. Use CURL_TIMECOND_IFMODSINCE to return the page only if it has been modified since the time specified in CURLOPT_TIMEVALUE. If it hasn't been modified, a "304 Not Modified" header will be returned assuming CURLOPT_HEADER is true. Use CURL_TIMECOND_IFUNMODSINCE for the reverse effect. CURL_TIMECOND_IFMODSINCE is the default. */
		'timecondition' => 'integer',
		/* The maximum number of seconds to allow cURL functions to execute. */
		'timeout' => 'integer',
		/* The maximum number of milliseconds to allow cURL functions to execute. If libcurl is built to use the standard system name resolver, that portion of the connect will still use full-second resolution for timeouts with a minimum timeout allowed of one second. */
		'timeout_ms' => 'integer',	// cURL v7.16.2.
		/* The time in seconds since January 1st, 1970. The time will be used by CURLOPT_TIMECONDITION. By default, CURL_TIMECOND_IFMODSINCE is used. */
		'timevalue' => 'integer',
		/* The time in seconds since January 1st, 1970. The time will be used by CURLOPT_TIMECONDITION. Defaults to zero. The difference between this option and CURLOPT_TIMEVALUE is the type of the argument. On systems where 'long' is only 32 bit wide, this option has to be used to set dates beyond the year 2038. */
		'timevalue_large' => 'integer',	// cURL v7.59.0.php 7.3.0.
		/* If a download exceeds this speed (counted in bytes per second) on cumulative average during the transfer, the transfer will pause to keep the average rate less than or equal to the parameter value. Defaults to unlimited speed. */
		'max_recv_speed_large' => 'integer',	// cURL v7.15.5.
		/* If an upload exceeds this speed (counted in bytes per second) on cumulative average during the transfer, the transfer will pause to keep the average rate less than or equal to the parameter value. Defaults to unlimited speed. */
		'max_send_speed_large' => 'integer',	// cURL v7.15.5.
		/* A bitmask consisting of one or more of CURLSSH_AUTH_PUBLICKEY, CURLSSH_AUTH_PASSWORD, CURLSSH_AUTH_HOST, CURLSSH_AUTH_KEYBOARD. Set to CURLSSH_AUTH_ANY to let libcurl pick one. */
		'ssh_auth_types' => 'integer',	// cURL v7.16.1.
		/* Allows an application to select what kind of IP addresses to use when resolving host names. This is only interesting when using host names that resolve addresses using more than one version of IP, possible values are CURL_IPRESOLVE_WHATEVER, CURL_IPRESOLVE_V4, CURL_IPRESOLVE_V6, by default CURL_IPRESOLVE_WHATEVER. */
		'ipresolve' => 'integer',	// cURL v7.10.8.
		/* Tell curl which method to use to reach a file on a FTP(S) server. Possible values are CURLFTPMETHOD_MULTICWD, CURLFTPMETHOD_NOCWD and CURLFTPMETHOD_SINGLECWD. */
		'ftp_filemethod' => 'integer',	// cURL v7.15.1.
		/* Enables the use of an abstract Unix domain socket instead of establishing a TCP connection to a host and sets the path to the given string. This option shares the same semantics as CURLOPT_UNIX_SOCKET_PATH. These two options share the same storage and therefore only one of them can be set per handle. */
		'abstract_unix_socket' => 'string',	// cURL v7.53.0php 7.3.0
		/* The name of a file holding one or more certificates to verify the peer with. This only makes sense when used in combination with CURLOPT_SSL_VERIFYPEER. */
		'cainfo' => 'string',
		/* A directory that holds multiple CA certificates. Use this option alongside CURLOPT_SSL_VERIFYPEER. */
		'capath' => 'string',
		/* The contents of the "Cookie: " header to be used in the HTTP request. Note that multiple cookies are separated with a semicolon followed by a space (e.g., "fruit=apple; colour=red") */
		'cookie' => 'string',
		/* The name of the file containing the cookie data. The cookie file can be in Netscape format, or just plain HTTP-style headers dumped into a file. If the name is an empty string, no cookies are loaded, but cookie handling is still enabled. */
		'cookiefile' => 'string',
		/* The name of a file to save all internal cookies to when the handle is closed, e.g. after a call to curl_close. */
		'cookiejar' => 'string',
		/* A cookie string (i.e. a single line in Netscape/Mozilla format, or a regular HTTP-style Set-Cookie header) adds that single cookie to the internal cookie store. "ALL" erases all cookies held in memory. "SESS" erases all session cookies held in memory. "FLUSH" writes all known cookies to the file specified by CURLOPT_COOKIEJAR. "RELOAD" loads all cookies from the files specified by CURLOPT_COOKIEFILE. */
		'cookielist' => 'string',	// cURL v7.14.1.
		/* A custom request method to use instead of "GET" or "HEAD" when doing a HTTP request. This is useful for doing "DELETE" or other, more obscure HTTP requests. Valid values are things like "GET", "POST", "CONNECT" and so on; i.e. Do not enter a whole HTTP request line here. For instance, entering "GET /index.html HTTP/1.0\r\n\r\n" would be incorrect. Note: Don't do this without making sure the server supports the custom request method first. */
		'customrequest' => 'string',
		/* The default protocol to use if the URL is missing a scheme name. */
		'default_protocol' => 'string',	// cURL v7.45.0.php 7.0.7.
		/* Set the name of the network interface that the DNS resolver should bind to. This must be an interface name (not an address). */
		'dns_interface' => 'string',	// cURL v7.33.0.php 7.0.7.
		/* Set the local IPv4 address that the resolver should bind to. The argument should contain a single numerical IPv4 address as a string. */
		'dns_local_ip4' => 'string',	// cURL v7.33.0.php 7.0.7.
		/* Set the local IPv6 address that the resolver should bind to. The argument should contain a single numerical IPv6 address as a string. */
		'dns_local_ip6' => 'string',	// cURL v7.33.0.php 7.0.7.
		/* Like CURLOPT_RANDOM_FILE, except a filename to an Entropy Gathering Daemon socket. */
		'egdsocket' => 'string',
		/* The contents of the "Accept-Encoding: " header. This enables decoding of the response. Supported encodings are "identity", "deflate", and "gzip". If an empty string, "", is set, a header containing all supported encoding types is sent. */
		'encoding' => 'string',	// cURL v7.10.
		/* The value which will be used to get the IP address to use for the FTP "PORT" instruction. The "PORT" instruction tells the remote server to connect to our specified IP address. The string may be a plain IP address, a hostname, a network interface name (under Unix), or just a plain '-' to use the systems default IP address. */
		'ftpport' => 'string',
		/* The name of the outgoing network interface to use. This can be an interface name, an IP address or a host name. */
		'interface' => 'string',
		/* The password required to use the CURLOPT_SSLKEY or CURLOPT_SSH_PRIVATE_KEYFILE private key. */
		'keypasswd' => 'string',	// cURL v7.16.1.
		/* The KRB4 (Kerberos 4) security level. Any of the following values (in order from least to most powerful) are valid: "clear", "safe", "confidential", "private".. If the string does not match one of these, "private" is used. Setting this option to null will disable KRB4 security. Currently KRB4 security only works with FTP transactions. */
		'krb4level' => 'string',
		/* Can be used to set protocol specific login options, such as the preferred authentication mechanism via "AUTH=NTLM" or "AUTH=*", and should be used in conjunction with the CURLOPT_USERNAME option. */
		'login_options' => 'string',	// cURL v7.34.0.php 7.0.7.
		/* Set the pinned public key. The string can be the file name of your pinned public key. The file format expected is "PEM" or "DER". The string can also be any number of base64 encoded sha256 hashes preceded by "sha256//" and separated by ";". */
		'pinnedpublickey' => 'string',	// cURL v7.39.0.php 7.0.7.
		/* The full data to post in a HTTP "POST" operation. This parameter can either be passed as a urlencoded string like 'para1=val1&para2=val2&...' or as an array with the field name as key and field data as value. If value is an array, the Content-Type header will be set to multipart/form-data. Files can be sent using CURLFile, in which case value must be an array. */
		'postfields' => 'string',
		/* Any data that should be associated with this cURL handle. This data can subsequently be retrieved with the CURLINFO_PRIVATE option of curl_getinfo(). cURL does nothing with this data. When using a cURL multi handle, this private data is typically a unique key to identify a standard cURL handle. */
		'private' => 'string',	// cURL v7.10.3.
		/* Set a string holding the host name or dotted numerical IP address to be used as the preproxy that curl connects to before it connects to the HTTP(S) proxy specified in the CURLOPT_PROXY option for the upcoming request. The preproxy can only be a SOCKS proxy and it should be prefixed with [scheme]:// to specify which kind of socks is used. A numerical IPv6 address must be written within [brackets]. Setting the preproxy to an empty string explicitly disables the use of a preproxy. To specify port number in this string, append :[port] to the end of the host name. The proxy's port number may optionally be specified with the separate option CURLOPT_PROXYPORT. Defaults to using port 1080 for proxies if a port is not specified. */
		'pre_proxy' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The HTTP proxy to tunnel requests through. */
		'proxy' => 'string',
		/* The proxy authentication service name. */
		'proxy_service_name' => 'string',	// cURL v7.34.0.php 7.0.7.
		/* The path to proxy Certificate Authority (CA) bundle. Set the path as a string naming a file holding one or more certificates to verify the HTTPS proxy with. This option is for connecting to an HTTPS proxy, not an HTTPS server. Defaults set to the system path where libcurl's cacert bundle is assumed to be stored. */
		'proxy_cainfo' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The directory holding multiple CA certificates to verify the HTTPS proxy with. */
		'proxy_capath' => 'string',	// cURL v7.52.0.php 7.3.0
		/* Set the file name with the concatenation of CRL (Certificate Revocation List) in PEM format to use in the certificate validation that occurs during the SSL exchange. */
		'proxy_crlfile' => 'string',	// cURL v7.52.0.php 7.3.0
		/* Set the string be used as the password required to use the CURLOPT_PROXY_SSLKEY private key. You never needed a passphrase to load a certificate but you need one to load your private key. This option is for connecting to an HTTPS proxy, not an HTTPS server. */
		'proxy_keypasswd' => 'string',	// cURL v7.52.0.php 7.3.0
		/* Set the pinned public key for HTTPS proxy. The string can be the file name of your pinned public key. The file format expected is "PEM" or "DER". The string can also be any number of base64 encoded sha256 hashes preceded by "sha256//" and separated by ";" */
		'proxy_pinnedpublickey' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The file name of your client certificate used to connect to the HTTPS proxy. The default format is "P12" on Secure Transport and "PEM" on other engines, and can be changed with CURLOPT_PROXY_SSLCERTTYPE. With NSS or Secure Transport, this can also be the nickname of the certificate you wish to authenticate with as it is named in the security database. If you want to use a file from the current directory, please precede it with "./" prefix, in order to avoid confusion with a nickname. */
		'proxy_sslcert' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The format of your client certificate used when connecting to an HTTPS proxy. Supported formats are "PEM" and "DER", except with Secure Transport. OpenSSL (versions 0.9.3 and later) and Secure Transport (on iOS 5 or later, or OS X 10.7 or later) also support "P12" for PKCS#12-encoded files. Defaults to "PEM". */
		'proxy_sslcerttype' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The list of ciphers to use for the connection to the HTTPS proxy. The list must be syntactically correct, it consists of one or more cipher strings separated by colons. Commas or spaces are also acceptable separators but colons are normally used, !, - and + can be used as operators. */
		'proxy_ssl_cipher_list' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The list of cipher suites to use for the TLS 1.3 connection to a proxy. The list must be syntactically correct, it consists of one or more cipher suite strings separated by colons. This option is currently used only when curl is built to use OpenSSL 1.1.1 or later. If you are using a different SSL backend you can try setting TLS 1.3 cipher suites by using the CURLOPT_PROXY_SSL_CIPHER_LIST option. */
		'proxy_tls13_ciphers' => 'string',	// cURL v7.61.0.php 7.3.0
		/* The file name of your private key used for connecting to the HTTPS proxy. The default format is "PEM" and can be changed with CURLOPT_PROXY_SSLKEYTYPE. (iOS and Mac OS X only) This option is ignored if curl was built against Secure Transport. */
		'proxy_sslkey' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The format of your private key. Supported formats are "PEM", "DER" and "ENG". */
		'proxy_sslkeytype' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The password to use for the TLS authentication method specified with the CURLOPT_PROXY_TLSAUTH_TYPE option. Requires that the CURLOPT_PROXY_TLSAUTH_USERNAME option to also be set. */
		'proxy_tlsauth_password' => 'string',	// cURL v7.52.0.php 7.3.0
		/* The method of the TLS authentication used for the HTTPS connection. Supported method is "SRP". Note: Secure Remote Password (SRP) authentication for TLS provides mutual authentication if both sides have a shared secret. To use TLS-SRP, you must also set the CURLOPT_PROXY_TLSAUTH_USERNAME and CURLOPT_PROXY_TLSAUTH_PASSWORD options. */
		'proxy_tlsauth_type' => 'string',	// cURL v7.52.0.php 7.3.0
		/* Tusername to use for the HTTPS proxy TLS authentication method specified with the CURLOPT_PROXY_TLSAUTH_TYPE option. Requires that the CURLOPT_PROXY_TLSAUTH_PASSWORD option to also be set. */
		'proxy_tlsauth_username' => 'string',	// cURL v7.52.0.php 7.3.0
		/* A username and password formatted as "[username]:[password]" to use for the connection to the proxy. */
		'proxyuserpwd' => 'string',
		/* A filename to be used to seed the random number generator for SSL. */
		'random_file' => 'string',
		/* Range(s) of data to retrieve in the format "X-Y" where X or Y are optional. HTTP transfers also support several intervals, separated with commas in the format "X-Y,N-M". */
		'range' => 'string',
		/* The contents of the "Referer: " header to be used in a HTTP request. */
		'referer' => 'string',
		/* The authentication service name. */
		'service_name' => 'string',	// cURL v7.43.0.php 7.0.7.
		/* A string containing 32 hexadecimal digits. The string should be the MD5 checksum of the remote host's public key, and libcurl will reject the connection to the host unless the md5sums match. This option is only for SCP and SFTP transfers. */
		'ssh_host_public_key_md5' => 'string',	// cURL v7.17.1.
		/* The file name for your public key. If not used, libcurl defaults to $HOME/.ssh/id_dsa.pub if the HOME environment variable is set, and just "id_dsa.pub" in the current directory if HOME is not set. */
		'ssh_public_keyfile' => 'string',	// cURL v7.16.1.
		/* The file name for your private key. If not used, libcurl defaults to $HOME/.ssh/id_dsa if the HOME environment variable is set, and just "id_dsa" in the current directory if HOME is not set. If the file is password-protected, set the password with CURLOPT_KEYPASSWD. */
		'ssh_private_keyfile' => 'string',	// cURL v7.16.1.
		/* A list of ciphers to use for SSL. For example, RC4-SHA and TLSv1 are valid cipher lists. */
		'ssl_cipher_list' => 'string',
		/* The name of a file containing a PEM formatted certificate. */
		'sslcert' => 'string',
		/* The password required to use the CURLOPT_SSLCERT certificate. */
		'sslcertpasswd' => 'string',
		/* The format of the certificate. Supported formats are "PEM" (default), "DER", and "ENG". As of OpenSSL 0.9.3, "P12" (for PKCS#12-encoded files) is also supported. */
		'sslcerttype' => 'string',	// cURL v7.9.3.
		/* The identifier for the crypto engine of the private SSL key specified in CURLOPT_SSLKEY. */
		'sslengine' => 'string',
		/* The identifier for the crypto engine used for asymmetric crypto operations. */
		'sslengine_default' => 'string',
		/* The name of a file containing a private SSL key. */
		'sslkey' => 'string',
		/* The secret password needed to use the private SSL key specified in CURLOPT_SSLKEY. Note: Since this option contains a sensitive password, remember to keep the PHP script it is contained within safe. */
		'sslkeypasswd' => 'string',
		/* The key type of the private SSL key specified in CURLOPT_SSLKEY. Supported key types are "PEM" (default), "DER", and "ENG". */
		'sslkeytype' => 'string',
		/* The list of cipher suites to use for the TLS 1.3 connection. The list must be syntactically correct, it consists of one or more cipher suite strings separated by colons. This option is currently used only when curl is built to use OpenSSL 1.1.1 or later. If you are using a different SSL backend you can try setting TLS 1.3 cipher suites by using the CURLOPT_SSL_CIPHER_LIST option. */
		'tls13_ciphers' => 'string',	// cURL v7.61.0.php 7.3.0
		/* Enables the use of Unix domain sockets as connection endpoint and sets the path to the given string. */
		'unix_socket_path' => 'string',	// cURL v7.40.0.php 7.0.7.
		/* The URL to fetch. This can also be set when initializing a session with curl_init(). */
		'url' => 'string',
		/* The contents of the "User-Agent: " header to be used in a HTTP request. */
		'useragent' => 'string',
		/* The user name to use in authentication. */
		'username' => 'string',	// cURL v7.19.1.
		/* A username and password formatted as "[username]:[password]" to use for the connection. */
		'userpwd' => 'string',
		/* Specifies the OAuth 2.0 access token. */
		'xoauth2_bearer' => 'string',	// cURL v7.33.0.php 7.0.7.
		/* Connect to a specific host and port instead of the URL's host and port. Accepts an array of strings with the format HOST:PORT:CONNECT-TO-HOST:CONNECT-TO-PORT. */
		'connect_to' => 'array',	// cURL v7.49.0.php 7.0.7.
		/* An array of HTTP 200 responses that will be treated as valid responses and not as errors. */
		'http200aliases' => 'array',	// cURL v7.10.3.
		/* An array of HTTP header fields to set, in the format array('Content-type: text/plain', 'Content-length: 100') */
		'httpheader' => 'array',
		/* An array of FTP commands to execute on the server after the FTP request has been performed. */
		'postquote' => 'array',
		/* An array of custom HTTP headers to pass to proxies. */
		'proxyheader' => 'array',	// cURL v7.37.0.php 7.0.7.
		/* An array of FTP commands to execute on the server prior to the FTP request. */
		'quote' => 'array',
		/* Provide a custom address for a specific host and port pair. An array of hostname, port, and IP address strings, each element separated by a colon. In the format: array("example.com:80:127.0.0.1") */
		'resolve' => 'array',	// cURL v7.21.3.
		/* The file that the transfer should be written to. The default is STDOUT (the browser window). */
		'file' => 'resource',
		/* The file that the transfer should be read from when uploading. */
		'infile' => 'resource',
		/* An alternative location to output errors to instead of STDERR. */
		'stderr' => 'resource',
		/* The file that the header part of the transfer is written to. */
		'writeheader' => 'resource',
		/* A callback accepting two parameters. The first is the cURL resource, the second is a string with the header data to be written. The header data must be written by this callback. Return the number of bytes written. */
		'headerfunction' => 'object',
		/* A callback accepting three parameters. The first is the cURL resource, the second is a string containing a password prompt, and the third is the maximum password length. Return the string containing the password. */
		'passwdfunction' => 'object',
		/* A callback accepting five parameters. The first is the cURL resource, the second is the total number of bytes expected to be downloaded in this transfer, the third is the number of bytes downloaded so far, the fourth is the total number of bytes expected to be uploaded in this transfer, and the fifth is the number of bytes uploaded so far. Note: The callback is only called when the CURLOPT_NOPROGRESS option is set to false. Return a non-zero value to abort the transfer. In which case, the transfer will set a CURLE_ABORTED_BY_CALLBACK error. */
		'progressfunction' => 'object',
		/* A callback accepting three parameters. The first is the cURL resource, the second is a stream resource provided to cURL through the option CURLOPT_INFILE, and the third is the maximum amount of data to be read. The callback must return a string with a length equal or smaller than the amount of data requested, typically by reading it from the passed stream resource. It should return an empty string to signal EOF. */
		'readfunction' => 'object',
		/* A callback accepting two parameters. The first is the cURL resource, and the second is a string with the data to be written. The data must be saved by this callback. It must return the exact number of bytes written or the transfer will be aborted with an error. */
		'writefunction' => 'object',
		/* A result of curl_share_init(). Makes the cURL handle to use the data from the shared handle. */
		'share' => 'object',
	];

	const METHOD_OPTIONS = [
		CURLOPT_HTTPGET => [Http::METHOD_GET],
		CURLOPT_POST => [Http::METHOD_POST],
		CURLOPT_PUT => [Http::METHOD_PUT],
		CURLOPT_CUSTOMREQUEST => [Http::METHOD_PATCH, Http::METHOD_DEL],
	];

	/* string key on curl_getinfo result array */
	const KEY_INFO_LOCATION = 'url';
	const KEY_INFO_MIMETYPE = 'content_type';
	const KEY_INFO_STATUS = 'http_code';
	const KEY_INFO_HEADER_LENGTH = 'header_size';
	const KEY_INFO_REQUEST_LENGTH = 'request_size';
	const KEY_INFO_FILETIME = 'filetime';
	const KEY_INFO_SSL_VERIFY_RESUL = 'ssl_verify_result';
	const KEY_INFO_CERT = 'certinfo';
	const KEY_INFO_REDIRECT_COUNT = 'redirect_count';
	const KEY_INFO_REDIRECT_URL = 'redirect_url';
	const KEY_INFO_REMOTE_IP = 'primary_ip';
	const KEY_INFO_REMOTE_PORT = 'primary_port';
	const KEY_INFO_LOCAL_IP = 'local_ip';
	const KEY_INFO_LOCAL_PORT = 'local_port';
	const KEY_INFO_TOTAL_TIME = 'total_time';
	const KEY_INFO_LOOKUP_TIME = 'namelookup_time';
	const KEY_INFO_CONNECT_TIME = 'connect_time';
	const KEY_INFO_PREPARE_TIME = 'pretransfer_time';
	const KEY_INFO_START_TIMING = 'starttransfer_time';
	const KEY_INFO_UPLOAD_SIZE = 'size_upload';
	const KEY_INFO_UPLOAD_SPEED = 'speed_upload';
	const KEY_INFO_UPLOAD_LENGTH = 'upload_content_length';
	const KEY_INFO_DOWNLOAD_SIZE = 'size_download';
	const KEY_INFO_DOWNLOAD_SPEED = 'speed_download';
	const KEY_INFO_DOWNLOAD_LENGTH = 'download_content_length';

	/* cURL setting options defaults.
	 - if not listed here :
		'bool' type defaults false
		'integer' type defaults 0
		'string' type defaults ''
	*/

	const OPTION_DEFAULTS = [
		CURLOPT_HEADER=> true,
		CURLOPT_COOKIE=> true,
		CURLOPT_FOLLOWLOCATION=> true,
		CURLOPT_RETURNTRANSFER =>  true,
	];


	protected static function parseKey(string $option) {
		return "CURLOPT_".strtoupper($option);
	}

	public static function key(string $option) :int {
		$opt = static::parseKey($option);
		if(array_key_exists($option, static::OPTIONS)) {
			return eval("return $opt;");
		} else {
			return 0;
		}
	}

	public static function getOption(array &$options, string $key) {
		if(static::exists($key)) {
			return $options[$key] ?? null;
		}
		// TODO exception handling
	}

	public static function setOption(array &$options, string $key, $value) {
		if(static::exists($key)) {
			if(static::validate($key, $value)) {
				$options[$key] = $value;
				return $options;
			}
			// TODO exception handling
		}
		// TODO exception handling
	}

	public static function converts(array $options) :array {
		$convertKey = self::class.'::key';
		$sets = [];
		foreach($options as $ok=>$ov) {
			$key = static::key($ok);
			if(0<$key && static::validate($ok, $ov)) {
				$sets[$key] = $ov;
			}
		}
		return $sets;
	}

	public static function exists(string $option) :bool {
		$key = static::parseKey($option);
		return array_key_exists($key, static::OPTIONS);
	}

	public static function validate(string $option, $value) :bool {
		$opt = static::parseKey($option);
		if(array_key_exists($option, static::OPTIONS)) {
			return static::OPTIONS($option) == gettype($value);
		} 
		return false;
	}

	public static function setMethodOptions(string $method, array &$options) {
		$method = strtoupper($method);
		$hasMatch = false;
		// clear method options
		foreach(static::METHOD_OPTIONS as $mk=>$mvs) {
			// should set but no
			$methodMatched = in_array($method, $mvs);
			$methodSetValue = $mk===CURLOPT_CUSTOMREQUEST ? $method : true;
			$methodGetValue = $options[$mk] ?? null;

			if($methodMatched) {
				$hasMatch = true;
				if($methodGetValue != $methodSetValue) {
					$options[$mk] = $methodSetValue;
				}
			}
			else if($methodGetValue!=null) {
				unset($options[$mk]);
			}
		}

		// if, has no match, return false
		return $hasMatch ? $options : false;
	}

	public static function setLocationParams(string $method, array &$options, ?string $location=null, ?array $params=null) {
		$method = strtoupper($method);
		$location = $location ?? $options[CURLOPT_URL];
		switch($method) {
			case Http::METHOD_GET:
				$location = Http::rebuildGetURI($location, $params);
				break;
			case Http::METHOD_POST:
			case Http::METHOD_PUT:
			default:
				if($params)
					$options[CURLOPT_POSTFIELDS] = http_build_query($params);
		}
		return $options;
	}

	public static function exec($curl, array &$options=[]) {
		// set options
		curl_setopt_array($curl, $options);

		// send
		return curl_exec($curl);
	}

	public static function parseResponse($curl, $responsed) : Response {
		$info = curl_getinfo($curl);
		$resp = null;
		// on OK:
		if($responsed!==false) {
			$resp = new Response($responsed, $info);
		} else {
			$err = curl_error($curl);
			// set header parsing to 0
			$info[cURL::KEY_INFO_HEADER_LENGTH] = '0';
			$resp = new Response($err, $info);
		}
		return $resp;

	}
}