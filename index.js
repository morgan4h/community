const express = require('express')
const fs = require('fs')
const path = require('path')
const app = express()

// Middleware
app.use(express.static('public'))
app.use(express.json())
app.use(express.urlencoded({ extended: true }))

// Enable CORS
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*')
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    res.header('Access-Control-Allow-Headers', 'Content-Type')
    if (req.method === 'OPTIONS') {
        return res.sendStatus(200)
    }
    next()
})

app.get("/download", (req,res) => {
    res.sendFile(__dirname + '/public/pages/download.html')
})

app.get("/apps", (req,res) => { 
    res.sendFile(__dirname + '/json/apps.json')
})

app.get('/api/app', (req,res) => {
    res.sendFile('/pages/download.html')
})


app.get('/write', (req,res) => {
    res.sendFile('/home/harold/Documents/web/projects/5Projects/download/public/pages/public.html')
})

app.post('/p', (req,res) => {
    res.send(req.body)
    console.log(req.body)
})

app.post('/upld', async (req, res) => {
    console.log('Received upload request:', req.body)
    const appsFilePath = path.join(__dirname, 'json', 'apps.json')
    
    // Read existing apps
    fs.readFile(appsFilePath, 'utf8', (err, data) => {
        if (err) {
            console.error('Error reading apps.json:', err)
            return res.status(500).json({ error: 'Failed to read apps file' })
        }

        try {
            const apps = JSON.parse(data)
            
            // Create new app object
            const newApp = {
                id: apps.length + 1,
                ...req.body
            }

            // Add to apps array
            apps.push(newApp)

            // Write back to file
            fs.writeFile(appsFilePath, JSON.stringify(apps, null, 2), 'utf8', (err) => {
                if (err) {
                    console.error('Error writing to apps.json:', err)
                    return res.status(500).json({ error: 'Failed to save app' })
                }
                
                res.json({ message: 'App added successfully', app: newApp })
            })
        } catch (err) {
            console.error('Error parsing apps.json:', err)
            res.status(500).json({ error: 'Failed to process request' })
        }
    })
})

app.listen(4040, () => {
    console.log('running server... http://localhost:4040')
})