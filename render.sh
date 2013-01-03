#!/bin/bash
echo Data.Lincoln Renderer

# ARGUMENTS:
# 1: Environment
# 2: Base URL
# 3: Nucleus URL
# 4: Nucleus Token
# 5: DB Host
# 6: DB User
# 7: DB Password
# 8: DB Name
# 9: Render Function

export CI_ENVIRONMENT=$1
export CI_BASE_URL=$2

export NUCLEUS_BASE_URI=$3
export NUCLEUS_TOKEN=$4

export DB_HOST=$5
export DB_USER=$6
export DB_PASS=$7
export DB_NAME=$8

php index.php render $9