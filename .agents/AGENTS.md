# Deployment & Troubleshooting Context (jagoskill.com)

This file contains important context about this workspace's server environment, deployment process, and known dependency issues. Always refer to this when modifying deployment scripts or troubleshooting server issues.

## 1. Hostinger / hPanel SSH Environment
- **Port**: The hPanel SSH daemon runs on Port `65002`.
- **IPv4 Enforcement**: The server's IPv6 configuration occasionally causes timeouts. Always force IPv4 in SSH commands (`-4`).
- **Host Keys**: Due to dynamic IPs or load balancers, host keys frequently mismatch. Deployments must use `-o StrictHostKeyChecking=no` and `-o UserKnownHostsFile=/dev/null`.
- **RSA Key Deprecation**: The modern OpenSSH version on the hPanel server rejects legacy RSA keys by default. Deployments using the existing RSA key MUST include the SSH flags:
  `-o PubkeyAcceptedKeyTypes=+ssh-rsa -o PubkeyAcceptedAlgorithms=+ssh-rsa`

## 2. Composer Dependency Failure (cinetpay)
- The application depends on `cinetpay/cinetpay-php`. The author deleted the source repository (`cinetpay/cinetpay-php-legacy`), resulting in a `404 Not Found` when running `composer install`.
- **Action Taken**: The `composer install` command has been **REMOVED** from `.github/workflows/deploy.yml` so that it does not block continuous deployment. 
- **Future Action**: If new composer packages are needed, `cinetpay` must be replaced or removed before `composer install` can be safely restored in the CI/CD pipeline. For now, rely on the pre-existing `vendor` folder on the server.

## 3. Deployment Paths & Credentials
- **Host**: `83.136.216.183`
- **User**: `u5266512`
- **Deploy Path**: `public_html/jagoskill.com`

## 4. CMS / Database Settings Mismatch
- The application uses extensive database-driven configuration (e.g., `getForumsGeneralSettings()`).
- If a page renders differently in production vs. localhost (e.g., 403 Forbidden pages, missing hero sections, or sad illustration images), it is almost always because the feature (like Forums) is toggled OFF in the production Admin Panel.
