#!/bin/bash
function jsonval {
    temp=`echo $json | sed 's/\\\\\//\//g' | sed 's/[{}]//g' | awk -v k="text" '{n=split($0,a,","); for (i=1; i<=n; i++) print a[i]}' | sed 's/\"\:\"/\|/g' | sed 's/[\,]/ /g' | sed 's/\"//g'`
    echo ${temp##*|}
}
json=`curl --data "username=$1&password=$2" http://localhost/api/tokens/creates.json`


arr=$(jsonval)
i=0
for x in $arr
do
	i=`expr $i + 1`
	if [ $i -eq 3 ]
	then
		username="$x"
	fi
	if [ $i -eq 5 ]
	then
		passwordDigest="$x"
	fi
	if [ $i -eq 7 ]
	then
		Nonce="$x"
	fi
	if [ $i -eq 9 ]
	then
		Created="$x"
	fi
done

echo 'UsernameToken Username="'$username'", PasswordDigest="'$passwordDigest'", Nonce="'$Nonce'", Created="'$Created'"'

