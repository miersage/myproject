
# remote web server
ip="192.168.75.129"
out="./2taskListCase.log"
echo -n >$out

# Test Create tasklists
echo -e "--Test Create tasklists\n" >>$out
curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/tasklist" \
  --data '{"accountId":1,"taskListName":"taskList11","status":1}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/tasklist" \
  --data '{"accountId":2,"taskListName":"taskList21","status":1}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/tasklist" \
  --data '{"accountId":2,"taskListName":"taskList22","status":1}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/tasklist" \
  --data '{"accountId":3,"taskListName":"taskList31","status":1}' \
  >>$out
echo -e "\n" >>$out

# Test List tasklists
echo -e "--Test List tasklists\n" >>$out
curl -X GET -i "http://$ip/api/tasklist" >>$out
echo -e "\n" >>$out

# Test Read tasklist 3
echo -e "--Test Read tasklist 3\n" >>$out
curl -X GET -i "http://$ip/api/tasklist/3" >>$out
echo -e "\n" >>$out

# Test List tasklists by account 2
echo -e "--Test List tasklists by account 2\n" >>$out
curl -X GET -i "http://$ip/api/tasklist1/2" >>$out
echo -e "\n" >>$out

# Test Modify tasklist 4
echo -e "--Test Modify tasklist 4\n" >>$out
curl -X PUT -H 'Content-Type: application/json' -i "http://$ip/api/tasklist/4" \
  --data '{"accountId":3,"taskListName":"taskList31b","status":1}' \
  >>$out
echo -e "\n" >>$out
echo -e "--Check List of tasklists\n" >>$out
curl -X GET -i "http://$ip/api/tasklist" >>$out
echo -e "\n" >>$out

# Test Delete tasklist 4
echo -e "--Test Delete tasklist 4\n" >>$out
curl -X DELETE -i "http://$ip/api/tasklist/4" >>$out
echo -e "\n" >>$out
echo -e "--Check List of tasklists\n" >>$out
curl -X GET -i "http://$ip/api/tasklist" >>$out
echo -e "\n" >>$out
