import os
from google_auth_oauthlib.flow import InstalledAppFlow

# The scopes required by the MCP server
SCOPES = ['https://www.googleapis.com/auth/drive.readonly', 'https://www.googleapis.com/auth/spreadsheets.readonly']

def main():
    creds = None
    if os.path.exists('credentials.json'):
        flow = InstalledAppFlow.from_client_secrets_file(
            'credentials.json', SCOPES)
        creds = flow.run_local_server(port=0)
        
        # Save the credentials for the next run
        with open('token.json', 'w') as token:
            token.write(creds.to_json())
        print("¡Éxito! token.json ha sido generado correctamente.")
    else:
        print("Error: credentials.json no se encuentra en esta carpeta.")

if __name__ == '__main__':
    main()
