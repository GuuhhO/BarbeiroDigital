# Configurar API WhatsApp

```
cd /var/www/Cortai/wwebjs-bot

npm install pm2 --save

npx pm2 start main.js --name cortai-bot

npx pm2 save

vim ~/.bashrc

No final do arquivo, adicione:
# Inicia o PM2 com processos salvos automaticamente
if command -v npx > /dev/null; then
    npx pm2 resurrect
fi

npx pm2 startup

npx pm2 ls

npx pm2 stop cortai-bot
npx pm2 logs cortai-bot
npx pm2 restart cortai-bot

npx pm2 logs cortai-bot