#!/bin/sh

if [ -z "$1" ]
    then
        echo "Release version wasn't specified";
        return;
fi

build_dir=$(dirname $0);
release_version=$1;

echo "Creating temporary directory"
rm -rf $build_dir/tawk-$release_version
mkdir $build_dir/tawk-$release_version

echo "Copying files to directory"
cp -r includes $build_dir/tawk-$release_version
cp -r YOUR_ADMIN_FOLDER $build_dir/tawk-$release_version
cp license.txt $build_dir/tawk-$release_version
cp README.md $build_dir/tawk-$release_version

echo "Creating zencart zip file"
(cd $build_dir && zip -9 -rq tawk-$release_version.zip tawk-$release_version)

echo "Cleaning up"
rm -rf $build_dir/tawk-$release_version

echo "Done!"
