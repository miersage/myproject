
# remote web server
ip="192.168.75.129"
out="./1accountCase.log"
echo -n >$out

# Test Create accounts
echo -e "--Test Create accounts\n" >>$out
curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/account" \
  --data '{"login":"user1","password":"user1","email":"user1@local.com","status":1}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/account" \
  --data '{"login":"user2","password":"user2","email":"user2@local.com","status":1}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/account" \
  --data '{"login":"user3","password":"user3","email":"user3@local.com","status":1}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/account" \
  --data '{"login":"user4","password":"user4","email":"user4@local.com","status":1}' \
  >>$out
echo -e "\n" >>$out

# Test List accounts
echo -e "--List accounts\n" >>$out
curl -X GET -i "http://$ip/api/account" >>$out
echo -e "\n" >>$out

# Test Read account 2
echo -e "--Test Read account 2\n" >>$out
curl -X GET -i "http://$ip/api/account/2" >>$out
echo -e "\n" >>$out

# Test Read account by login user3
echo -e "--Read account by login user3\n" >>$out
curl -X GET -i "http://$ip/api/account1/user3" >>$out
echo -e "\n" >>$out

# Test Modify account 4
echo -e "--Test Modify account 4\n" >>$out
curl -X PUT -H 'Content-Type: application/json' -i "http://$ip/api/account/4" \
  --data '{"login":"user4b","password":"user4b","email":"user4b@local.com","status":1}' \
  >>$out
echo -e "\n" >>$out
echo -e "--Check List of accounts\n" >>$out
curl -X GET -i "http://$ip/api/account" >>$out
echo -e "\n" >>$out

# Test Delete account 4
echo -e "--Test Delete account 4\n" >>$out
curl -X DELETE -i "http://$ip/api/account/4" >>$out
echo -e "\n" >>$out
echo -e "--Check List of accounts\n" >>$out
curl -X GET -i "http://$ip/api/account" >>$out
echo -e "\n" >>$out
