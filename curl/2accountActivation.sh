
# remote web server
ip="192.168.75.129"
out="./$0.log"
echo -n >$out

# Test activate account 1
echo -e "--Test activate account 1\n" >>$out
echo -e "--NOT DONE You have to replace the activation key\n" >>$out
#curl -X GET -i "http://$ip/api/accountM/activate/1/4c8bfdc6-24e4-4c40-a719-ce576dc59d64" >>$out
echo -e "\n" >>$out

# Test Read account 1
echo -e "--Test Read account 1\n" >>$out
#curl -X GET -i "http://$ip/api/account/1" >>$out
echo -e "\n" >>$out
