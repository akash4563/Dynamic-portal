#!/bin/bash
# Shell script to orchestrate updates using the python backend
# This script can be run on a cron job or manually

echo "Starting data update process..."

# Check if python3 is available
if command -v python3 &>/dev/null; then
    PYTHON_CMD="python3"
elif command -v python &>/dev/null; then
    PYTHON_CMD="python"
else
    echo "Error: Python is not installed or not in PATH."
fi

# Run the python script to update data
$PYTHON_CMD update_data.py "System Status" "New Alert" "#alert" "Storage Tools"

if [ $? -eq 0 ]; then
    echo "Data update completed successfully."
else
    echo "Error: Data update failed."
fi
