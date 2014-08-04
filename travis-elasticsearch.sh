#!/bin/sh

download() {
    echo "Downloading Elasticsearch from $1..."
    curl -s $1 | tar xz
    echo "Downloaded"
}

is_elasticsearch_up(){
    http_code=`echo $(curl -s -o /dev/null -w "%{http_code}" "http://localhost:9200")`
    return `test $http_code = "200"`
}

wait_for_elasticsearch(){
    while ! is_elasticsearch_up; do
        sleep 3
    done
}

run() {
    echo "Starting Elasticsearch..."
    cd $1/bin
    if [ $DEBUG ]
    then
        ./elasticsearch
    else
        ./elasticsearch > /dev/null 2>&1 &
    fi
    wait_for_elasticsearch
    cd ../../
    echo "Started."
}

download_and_run() {
    url="http://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-$1.tar.gz"
    dir_name="elasticsearch-$1"
    dir_mappings="eZ/Publish/Core/Persistence/Elasticsearch/Content/Search/Resources/mappings"
    mappings=(content.json location.json)

    download $url

    # Configure mappings
    mkdir $dir_name/config/mappings
    mkdir $dir_name/config/mappings/ezpublish

    for file in ${mappings[@]}
    do
        if [ -f $dir_mappings/$file ]
        then
            cp $dir_mappings/$file $dir_name/config/mappings/ezpublish
            echo "Copied $file into Elasticsearch config/mappings/ezpublish directory."
        fi
    done

    # Run elasticsearch
    run $dir_name
}

check_version() {
    case $1 in
        1.2.2|1.2.3|1.3.0|1.3.1);;
        *)
            echo "Sorry, $1 is not supported or not valid version."
            exit 1
            ;;
    esac
}

check_version $ELASTICSEARCH_VERSION
download_and_run $ELASTICSEARCH_VERSION
