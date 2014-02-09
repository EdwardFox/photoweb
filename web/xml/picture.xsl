<?xml version="1.0" encoding="UTF-8"?>
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
                <table cellspacing="15" cellpadding="0" style="font-family:Helvetica, Arial, sans-serif; font-size:0.9em;">
                    <tr align="left" style="background: #ccc;">
                        <th style="padding:5px;">ID</th>
                        <th style="padding:5px;">Name</th>
                        <th style="padding:5px;">Pfad</th>
                        <th style="padding:5px;">Format</th>
                        <th style="padding:5px;">Farbe/Schwarzweiß</th>
                        <th style="padding:5px;">Breite</th>
                        <th style="padding:5px;">Höhe</th>
                    </tr>
                    <xsl:for-each select="pictures/picture">          
          
                        <tr>
                            <td style="padding:5px;">
                                <xsl:value-of select="@id" />
                            </td>
                            <td style="padding:5px;"> 
                                <xsl:value-of select="name" /> 
                            </td>   
                            <td style="padding:5px;"> 
                                <xsl:value-of select="path" /> 
                            </td>                            
                            <td style="padding:5px;"> 
                                <xsl:value-of select="format" /> 
                            </td>
                            <td style="padding:5px;">
                                <xsl:value-of select="color" /> 
                            </td>
                            <td style="padding:5px;">
                                <xsl:value-of select="width" /> 
                            </td>
                            <td style="padding:5px;">
                                <xsl:value-of select="height" /> 
                            </td>
                        </tr>
                    </xsl:for-each>
                </table>      
            </body>
        </html>
    </xsl:template>
    
</xsl:stylesheet>
