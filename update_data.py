import json
import os
import sys

DATA_FILE = 'data.json'

def load_data():
    if not os.path.exists(DATA_FILE):
        return {"categories": []}
    with open(DATA_FILE, 'r') as f:
        try:
            return json.load(f)
        except json.JSONDecodeError:
            return {"categories": []}

def save_data(data):
    with open(DATA_FILE, 'w') as f:
        json.dump(data, f, indent=4)

def update_link(category_title, link_title, new_url):
    data = load_data()
    updated = False

    for category in data.get('categories', []):
        if category['title'].lower() == category_title.lower():
            for link in category.get('links', []):
                if link['title'].lower() == link_title.lower():
                    link['url'] = new_url
                    updated = True
                    break

    if updated:
        save_data(data)
        print(f"Successfully updated '{link_title}' in '{category_title}' to '{new_url}'.")
    else:
        print(f"Failed to find '{link_title}' in '{category_title}'.")

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: python update_data.py <Category Title> <Link Title> <New URL>")
        sys.exit(1)

    cat_title = sys.argv[1]
    link_title = sys.argv[2]
    new_url = sys.argv[3]

    update_link(cat_title, link_title, new_url)
