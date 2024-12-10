# Use a imagem do Node.js como base
FROM node:14

# Defina o diretório de trabalho dentro do contêiner
WORKDIR /app

# Copie o package.json e package-lock.json
COPY package*.json ./

# Instale as dependências do projeto
RUN npm install

# Copie o código do aplicativo para o contêiner
COPY . .

# Compile o aplicativo React para produção
RUN npm run build

# Use uma imagem nginx para servir os arquivos estáticos
FROM nginx:alpine

# Copie os arquivos construídos para a pasta padrão do nginx
COPY --from=0 /app/build /usr/share/nginx/html

# Exponha a porta 80
EXPOSE 80

# Inicie o nginx
CMD ["nginx", "-g", "daemon off;"]
