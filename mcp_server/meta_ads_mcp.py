import os
import sys
import json
import requests
from typing import Any, Dict, List, Optional
from dotenv import load_dotenv

from mcp.server.fastmcp import FastMCP

# Load environment variables from the same directory as the script
try:
    script_dir = os.path.dirname(os.path.abspath(__file__))
except NameError:
    script_dir = os.getcwd()
env_path = os.path.join(script_dir, '.env')
load_dotenv(dotenv_path=env_path)

META_ACCESS_TOKEN = os.getenv("META_ACCESS_TOKEN")
META_BUSINESS_ID = os.getenv("META_BUSINESS_ID")

if not META_ACCESS_TOKEN:
    print("Error: META_ACCESS_TOKEN environment variable is not set.", file=sys.stderr)
    sys.exit(1)

# Initialize FastMCP server
mcp = FastMCP("meta-ads")

BASE_URL = "https://graph.facebook.com/v19.0"

def _make_request(endpoint: str, params: Dict[str, Any] = None) -> Dict[str, Any]:
    """Helper function to make requests to the Meta Graph API."""
    if params is None:
        params = {}
    params["access_token"] = META_ACCESS_TOKEN
    
    url = f"{BASE_URL}/{endpoint}"
    
    try:
        response = requests.get(url, params=params)
        response.raise_for_status()
        return response.json()
    except requests.exceptions.RequestException as e:
        error_msg = str(e)
        if e.response is not None:
            try:
                error_data = e.response.json()
                error_msg += f" - Response: {json.dumps(error_data)}"
            except ValueError:
                error_msg += f" - Response: {e.response.text}"
        return {"error": error_msg}


@mcp.tool()
def get_ad_accounts() -> Dict[str, Any]:
    """
    Get the list of ad accounts accessible by this system user token.
    This is useful for finding the exact act_... ID needed for other queries.
    """
    return _make_request("me/adaccounts", {"fields": "id,name,account_id,account_status,currency,timezone_name"})

@mcp.tool()
def get_campaign_metrics(ad_account_id: str, date_preset: str = "last_30d") -> Dict[str, Any]:
    """
    Get performance metrics (spend, reach, impressions, cpc, cpm, cpp, ctr, objective, actions) 
    for campaigns in a specific ad account.
    
    Args:
        ad_account_id: The ID of the ad account (starts with 'act_')
        date_preset: Date range (e.g., 'today', 'yesterday', 'last_7d', 'last_30d', 'this_month')
    """
    # ensure it starts with act_
    if not ad_account_id.startswith('act_'):
        ad_account_id = f"act_{ad_account_id}"
        
    params = {
        "level": "campaign",
        "fields": "campaign_name,spend,reach,impressions,cpc,cpm,cpp,ctr,objective,actions,cost_per_action_type",
        "date_preset": date_preset
    }
    return _make_request(f"{ad_account_id}/insights", params)

@mcp.tool()
def get_leads_data(form_id: str) -> Dict[str, Any]:
    """
    Get the latest leads submitted to a specific lead generation form.
    
    Args:
        form_id: The ID of the lead generation form.
    """
    params = {
        "fields": "created_time,field_data"
    }
    return _make_request(f"{form_id}/leads", params)

@mcp.tool()
def custom_graph_api_query(endpoint: str, fields: str = "") -> Dict[str, Any]:
    """
    Run a custom query against the Meta Graph API.
    
    Args:
        endpoint: The API endpoint (e.g., 'me/accounts', '994176996424524/client_ad_accounts')
        fields: Comma-separated list of fields to request (e.g., 'id,name')
    """
    params = {}
    if fields:
        params["fields"] = fields
    return _make_request(endpoint, params)

if __name__ == "__main__":
    mcp.run(transport='stdio')
