#!/usr/bin/env sh

# TODO: Only pipe to `src/Acme/OnlineShop/messages.php` when command returned with exit code 0
bin/generate-code.php src/Acme/OnlineShop/messages.yaml messages > src/Acme/OnlineShop/messages.php
bin/generate-code.php src/Acme/OnlineShop/messages.yaml handlers > src/Acme/OnlineShop/handlers.php

bin/generate-code.php src/TicketBlaster/ExperimentalTicketChecking/messages.yaml messages > src/TicketBlaster/ExperimentalTicketChecking/messages.php
