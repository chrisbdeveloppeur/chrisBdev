#!/bin/sh
rsync -avz ./ -e "ssh -p 5022"  chrivakn@world-372.fr.planethoster.net:~/public_html/chrisbdev --include=public/build --include=public/bundles --include=public/.htaccess --include=vendor --exclude-from=.gitignore --exclude=".*" --exclude="public/images"