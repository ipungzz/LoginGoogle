
cloudflared tunnel --url http://10.10.10.21/

cloudflared tunnel login
cloudflared tunnel create web

config.yml
url: http://10.10.10.21/
tunnel: <Tunnel-UUID>
credentials-file: C:\Users\Yukebrillianth\.cloudflared\<Tunnel-UUID>.json

Routing Tunnel :
cloudflared tunnel route dns <UUID or NAME> <hostname>

Running Tunnel :
cloudflared tunnel run <Tunnel-UUID>

Config lebih dari satu host :

tunnel: <Tunnel-UUID>
credentials-file: C:\Users\COMP_NAME\.cloudflared\<Tunnel-UUID>.json
ingress:
  - hostname: sub.domain.com
    service: http://localhost:port
  - hostname: sub.domain.com
    service: http://localhost:port
    # An example of a catch-all rule:
  - service: http_status:404

Validasi Ingress :
cloudflared tunnel ingress validate

Routing semua domain.

setting cloudflared.txt
Menampilkan setting cloudflared.txt.