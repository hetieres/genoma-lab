# Alias para CRON
alias cron-start="systemctl start crond"
alias cron-status="systemctl status crond"
alias cron-restart="systemctl restart crond"

# Git
alias gtp="git pull origin development"
alias cassets="copy_assets"

# Functions Alias
function copy_assets() {
    echo "Copiando assets para "$1
}
