#!/bin/sh
for file in `find * -maxdepth 0 -name "*.css" `
do
echo "Compressing $file …"
yui-compressor  --type css   -o  ".css$:.min.css" $file
done
echo "Move All Minified File to min folder"
for hasil in `find * -maxdepth 0 -name  "*.min.css"`
do
echo "moving file $hasil .."
mv $hasil min
done
