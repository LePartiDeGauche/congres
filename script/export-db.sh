#!/bin/bash

#Vars
dbfile=base.mdb
outputfile=export.sql
backend=mysql
outputdatabase=access_legacy
table_list="fonction_elective Fonction_local_prs Fonction_national_prs Fonction_dep_prs TGF L_Statut"

table_names=`mktemp`

if [ "$table_list" = "" ] ; then
    mdb-tables -1 $dbfile > $table_names;
else
    for i in $table_list; do
        echo $i >> $table_names
    done
fi

echo "SET autocommit=0;" > $outputfile
echo "preparing $outputdatabase database creation..."
echo "CREATE DATABASE IF NOT EXISTS $outputdatabase;" >> $outputfile
echo "COMMIT;" >> $outputfile

while read -r x ; do
    echo exporting "$x" schema...
   mdb-schema -T $x --relations --indexes --drop-table --no-not-null --default-values --not-empty --comments $dbfile $backend >> $outputfile
#--not-null
done < $table_names
echo "COMMIT;" >> $outputfile

while read -r x ; do
    echo exporting "$x" data...
    mdb-export "$dbfile" "$x" -I $backend -H >> $outputfile;
done < $table_names
echo "COMMIT;" >> $outputfile


echo 'importing ' $outputdatabase 'in ' $backend ', It can take a while...'
mysql -u root -D $outputdatabase < $outputfile &&
echo "importation successful"

echo ""

echo "duplicated Email adresses"
echo "SELECT Email_perso FROM TGF WHERE Statut = 1 OR Statut = 7 GROUP BY Email_perso HAVING
COUNT(*) >= 2;" | mysql -u root -D $outputdatabase
