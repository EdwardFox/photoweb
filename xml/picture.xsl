<?xml version="1.0" encoding="UTF-8"?>
<!--<?xml version="1.0" encoding="ISO-8859-1"?>-->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>
                    <xsl:value-of select="pictures/title"/>
                </title>
            </head>
            <body>
                <table cellspacing="15" cellpadding="0" style="background:gold; font-family:Helvetica, Arial, sans-serif; font-size:0.9em;">
                    <tr align="left" style="background: red;">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Größe</th>
                        <th>Format</th>
                        <th>Farbe</th>
                    </tr>
                    <xsl:for-each select="pictures/picture">          
          
                        <tr>
                            <td></td>
                            <td> 
                                <xsl:value-of select="name"/> 
                            </td>
                            <td> 
                                <xsl:value-of select="size"/> 
                            </td>
                            <td> 
                                <xsl:value-of select="direction"/> 
                            </td>
                            <td>
                                <xsl:value-of select="color"/> 
                            </td>
                        </tr>
                    </xsl:for-each>
                </table>      
            </body>
        </html>
    </xsl:template>
    
</xsl:stylesheet>
