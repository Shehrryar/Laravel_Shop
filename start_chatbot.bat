@echo off
cd /d "%~dp0chartbot"
python -m pip install -r requirements.txt
python -m uvicorn chat:app --host 127.0.0.1 --port 8000 --reload
pause