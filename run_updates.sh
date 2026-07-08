#!/bin/bash

echo "Starting automated portal updates..."

# Example of updating data.json using the python script
# This could be triggered by a cron job
python3 update_data.py "Vendors Portal" "Vendor A Login" "https://vendor-a.example.com"
python3 update_data.py "Internal Tool" "Leave Management" "https://leave.example.com"

echo "Portal updates completed."
