import json
import os
import sys
import urllib.request
import urllib.error

DATA_FILE = 'data.json'
KV_URL = os.environ.get('KV_REST_API_URL')
KV_TOKEN = os.environ.get('KV_REST_API_TOKEN')

def load_data():
    if KV_URL and KV_TOKEN:
        try:
            req = urllib.request.Request(f"{KV_URL}/get/portal_data")
            req.add_header('Authorization', f"Bearer {KV_TOKEN}")
            with urllib.request.urlopen(req) as response:
                res_data = json.loads(response.read().decode())
                if 'result' in res_data and res_data['result'] is not None:
                    parsed = json.loads(res_data['result'])
                    return parsed
        except Exception as e:
            print(f"Error reading from KV: {e}")
            pass

    if not os.path.exists(DATA_FILE):
        return {"categories": []}
    with open(DATA_FILE, 'r') as f:
        try:
            return json.load(f)
        except json.JSONDecodeError:
            return {"categories": []}

def save_data(data):
    if KV_URL and KV_TOKEN:
        try:
            payload = json.dumps(json.dumps(data)).encode('utf-8')
            req = urllib.request.Request(f"{KV_URL}/set/portal_data", data=payload, method='POST')
            req.add_header('Authorization', f"Bearer {KV_TOKEN}")
            req.add_header('Content-Type', 'text/plain')
            with urllib.request.urlopen(req) as response:
                if response.status >= 200 and response.status < 300:
                    return
        except Exception as e:
            print(f"Error saving to KV: {e}")
            pass

    with open(DATA_FILE, 'w') as f:
        json.dump(data, f, indent=4)

def add_or_update_link(category_title, link_title, new_url):
    data = load_data()

    if 'categories' not in data:
        data['categories'] = []

    target_category = None
    for category in data['categories']:
        if category['title'].lower() == category_title.lower():
            target_category = category
            break

    if not target_category:
        target_category = {
            "id": len(data['categories']) + 1,
            "title": category_title,
            "links": []
        }
        data['categories'].append(target_category)

    if 'links' not in target_category:
        target_category['links'] = []

    link_updated = False
    for link in target_category['links']:
        if link['title'].lower() == link_title.lower():
            link['url'] = new_url
            link_updated = True
            break

    if not link_updated:
        target_category['links'].append({
            "title": link_title,
            "url": new_url
        })
        print(f"Successfully added '{link_title}' to '{category_title}' with URL '{new_url}'.")
    else:
        print(f"Successfully updated '{link_title}' in '{category_title}' to '{new_url}'.")

    save_data(data)

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: python update_data.py <Category Title> <Link Title> <New URL>")
        sys.exit(1)

    cat_title = sys.argv[1]
    link_title = sys.argv[2]
    new_url = sys.argv[3]

    add_or_update_link(cat_title, link_title, new_url)
