<?php
    //Local Database configuration
    $LOCAL_HOST       = 'localhost'; //127.0.0.1
    $LOCAL_DBNAME     = 'app_beta';
    $LOCAL_USERNAME   = 'postgres';
    $LOCAL_PASSWORD   = 'unicesmag';
    $LOCAL_PORT       = '5432';

    //Supabase Database configuration
    $SUPA_HOST        = 'aws-1-us-west-2.pooler.supabase.com';
    $SUPA_DBNAME      = 'postgres';
    $SUPA_USERNAME    = 'postgres.zfspfraieickuhjzpurr';
    $SUPA_PASSWORD    = 'unicesmag69';
    $SUPA_PORT        = '6543'

    ;

    //Local Database connection
    $local_data_connection = "
    host             =$LOCAL_HOST
    dbname           =$LOCAL_DBNAME
    user             =$LOCAL_USERNAME
    password         =$LOCAL_PASSWORD
    port             =$LOCAL_PORT
    ";


    //Supa Database connection
     $supa_data_connection = "
    host             =$SUPA_HOST
    dbname           =$SUPA_DBNAME
    user             =$SUPA_USERNAME
    password         =$SUPA_PASSWORD
    port             =$SUPA_PORT
    sslmode=require
    ";

    $local_conn = pg_connect($local_data_connection, PGSQL_CONNECT_FORCE_NEW);

    if(!$local_conn){
        echo "Error: Unable to connect to local database";
        exit();
    }else{
        echo "local success connection!!!";
    }


    $supa_conn = pg_connect($supa_data_connection, PGSQL_CONNECT_FORCE_NEW);

    if(!$supa_conn){
        if(!$supa_conn){
    echo pg_last_error(); // muestra el error real
    exit();
}
    }else{
        echo " <br> Supabase success connection!!!";
    }
        
?>


