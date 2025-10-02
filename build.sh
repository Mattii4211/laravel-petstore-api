#!/bin/bash
set -e  # stop the script immediately if any command fails

PROJECT_NAME="Junior_PHP_Developer"

echo "Building containers for project: $PROJECT_NAME..."

# Build Docker images
if ! docker-compose build; then
  echo "Error while building images!"
  exit 1
fi

# Start containers in detached mode
if ! docker-compose up -d; then
  echo "Error while starting containers!"
  docker-compose down
  exit 1
fi

# Check container status
echo "🔍 Checking container status..."
if ! docker-compose ps; then
  echo "Containers did not start correctly!"
  docker-compose down
  exit 1
fi

echo "ontainers are running successfully"
echo "You can access the application at http://localhost:8000"
echo "To stop the containers, run: docker-compose down"
echo "To view logs, run: docker-compose logs -f"