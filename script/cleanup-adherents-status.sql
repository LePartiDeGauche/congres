# Update invalid status of adherents to "À jour de cotisation."

UPDATE adherents SET status="À jour de cotisation." WHERE status=0;
