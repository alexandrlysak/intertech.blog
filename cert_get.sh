docker run -it --rm \
      -v /home/ludoandhedo.com/certificates:/etc/letsencrypt \
      -v /home/ludoandhedo.com/frontend/letsencrypt:/data/letsencrypt \
      deliverous/certbot \
      certonly \
      --webroot --webroot-path=/data/letsencrypt \
      -m contact@ludoandhedo.com \
      -d ludoandhedo.com -d www.ludoandhedo.com