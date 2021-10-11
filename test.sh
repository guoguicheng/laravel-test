!/bin/sh

curl -v -X POST https://api.line.me/oauth2/v2.1/token \
    -H 'Content-Type: application/x-www-form-urlencoded' \
    -d 'grant_type=authorization_code' \
    -d 'code=1656520070' \
    -d 'redirect_uri=https://www.baidu.com' \
    -d 'client_id=Ue2ffc35f66d3bbe1394b897dd58fd416' \
    -d 'client_secret=142ef13729a0e8a47a927f22106c9319'
