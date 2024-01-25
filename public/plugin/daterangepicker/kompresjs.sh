#!/bin/sh
for file in `find * -maxdepth 0 -name "*.js" `
do
echo "Compressing $file …"
yui-compressor  --type js   -o  ".js$:.min.js" $file
done
echo "Move All Minified File to min folder"
for hasil in `find * -maxdepth 0 -name  "*.min.js"`
do
echo "moving file $hasil .."
mv $hasil min
done
