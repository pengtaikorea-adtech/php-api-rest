/** 
 * ApiSync\cURL.php const OPTIONS auto generator. 
 * Run on  https://www.php.net/manual/en/function.curl-setopt.php
 **/

console.log((function() {
  const tablesSelector = '[id="refsect1-function.curl-setopt-parameters"] table.doctable.informaltable';
  // bool, int, string, array, resources(stream), callable(function/closure), others
  const types = ['bool', 'int', 'string', 'array', 'resource', 'object', 'object'];
  tables = Array(...document.querySelectorAll(tablesSelector));

  buf = [];
  tables
    .map((tb,ti)=>{
      let rtype = types[ti];
      let rows = Array(...tb.querySelectorAll('tbody tr'));
      return {
          _e: tb,
          _rs: rows,
          returns: rtype,
          values: rows.map((r)=>Array(...r.querySelectorAll('td')).map((c)=>c.textContent.trim())),
      }
    })
    .forEach((rt)=>{
      // return types
      rt.values.forEach(([name,desc,cmt])=>{
        let key = name.replace(/^CURLOPT_/, '').toLowerCase();
        desc = desc.replace(/[\r\n]+/g, ' ').replace(/\s+/g, ' ');
        let curl = /cURL (?<version>[\d\.]+)/i.exec(cmt);
        let php = /php (?<version>[\d\.]+)/i.exec(cmt);

        buf.push(`/* ${desc} */`);
        let line = `'${key}' => '${rt.returns}',`;
        if(curl || php) {
            line += `\t// ${curl?'cURL v' + curl.groups.version:''}${php?'php '+php.groups.version:''}`;
        }
        buf.push(line);
      });
    });
  return `[\n${buf.map((ln)=>'\t'+ln).join('\n')}\n];`;
})());