const express = require('express')
const app = express()

app.use(express.static('public'))

app.get("/download", (req,res) => {
    res.sendFile(__dirname + '/public/pages/download.html')
})

app.get("/apps", (req,res) => { 
    res.sendFile(__dirname + '/json/apps.json')
})

app.listen(4040, () => {
    console.log('running server... http://localhost:4040')
})