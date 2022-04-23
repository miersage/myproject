
# remote web server
ip="192.168.75.129"
out="./$0.log"
echo -n >$out

# Test Delete account 1 on cascade
echo -e "--Test Delete account 1 on cascade\n" >>$out
curl -X DELETE -i "http://$ip/api/account/1" >>$out
echo -e "\n" >>$out

echo -e "--Check List of accounts\n" >>$out
curl -X GET -i "http://$ip/api/account" >>$out
echo -e "\n" >>$out

echo -e "--Check List of tasklists\n" >>$out
curl -X GET -i "http://$ip/api/tasklist" >>$out
echo -e "\n" >>$out

echo -e "--Check List of tasks\n" >>$out
curl -X GET -i "http://$ip/api/task" >>$out
echo -e "\n" >>$out
