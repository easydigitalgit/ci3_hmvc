#!/bin/sh
#minification of JS files
for file in `find * -maxdepth 0 -name "*.js" `
do
echo "Compressing $file …"
uglifyjs $file -m -c -o "${file%.js}.min.js"
done
echo "Move All Minified File to min folder"
for hasil in `find * -maxdepth 0 -name  "*.min.js"`
do
echo "moving file $hasil .."
mv $hasil min
done
