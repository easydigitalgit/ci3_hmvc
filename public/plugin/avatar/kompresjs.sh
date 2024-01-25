#!/bin/sh
#minification of JS files
for file in `find * -maxdepth 0 -name "*.js" `
do
uglifyjs $file -m -c -o "${file%.js}.min.js"
echo "Compressing $file …"

done

