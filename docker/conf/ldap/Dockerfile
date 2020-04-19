FROM osixia/openldap:1.2.5  
#(openldap 2.4)

RUN apt-get update && apt-get install -y openssh-server 

RUN echo 'root:root' | chpasswd
RUN sed -i -E 's/#?PasswordAuthentication\s.*/PasswordAuthentication yes/g' /etc/ssh/sshd_config
RUN sed -i -E 's/#?PermitRootLogin\s.*/PermitRootLogin yes/g' /etc/ssh/sshd_config
RUN sed -i -E 's/#?PubkeyAuthentication\s.*/PubkeyAuthentication yes/g' /etc/ssh/sshd_config

ENTRYPOINT /etc/init.d/ssh start && /container/tool/run

#/root/.ssh/authorized_keys
# ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDkHII/FKbMpoYPctRY7PO0ZnkNncYdjXmwzP/i8Hjbu1+FHnG3VD5AMX8AKsCRpCJaWyKU3hWDX/P7lw7OuBbWY+evfTnc8nlOd47eO3rMSTaHgnVLe2S7z8BV4wOF4hCvjJODXPhpSXiJeQxsVxWg4RtJfUfLKWnr6pBYoI38CERAVaHasKwfg4bpSO+lynonh4h/ewW+NSOrweoJ6nJXGfD8fK1b8LXhjtz2e7OwyR8WKtVybcfcKkwXFwUdhpnZ+qxrxgORZ2CLHY9XZh6s/oQq+AX15LGDd3V2TozRIL0kKKNiWBPIVuVOQ++3gsNxqbDPWgwNO1tIt5A+fQBT root@8a076ff5be7d