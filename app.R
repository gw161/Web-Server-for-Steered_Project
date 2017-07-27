library(shiny)
rsem_rn4_untrimmed <- read.csv(file="/home/srp2017a/ShinyApps/rsem_rn4_untrimmed.csv", header=TRUE, sep="\t")
rsem_rn4_trimmed <- read.csv(file="/home/srp2017a/ShinyApps/rsem_rn4_trimmed.csv", header=TRUE, sep="\t")
rsem_rn6_untrimmed <- read.csv(file="/home/srp2017a/ShinyApps/rsem_rn6_untrimmed.csv", header=TRUE, sep="\t")
rsem_rn6_trimmed <- read.csv(file="/home/srp2017a/ShinyApps/rsem_rn6_trimmed.csv", header=TRUE, sep="\t")

tophat_rn4_untrimmed <- read.csv(file="/home/srp2017a/ShinyApps/tophat_rn4_untrimmed.csv", header=TRUE, sep="\t")
tophat_rn4_trimmed <- read.csv(file="/home/srp2017a/ShinyApps/tophat_rn4_trimmed.csv", header=TRUE, sep="\t")
tophat_rn6_untrimmed <- read.csv(file="/home/srp2017a/ShinyApps/tophat_rn6_untrimmed.csv", header=TRUE, sep="\t")
tophat_rn6_trimmed <- read.csv(file="/home/srp2017a/ShinyApps/tophat_rn4_trimmed.csv", header=TRUE, sep="\t")


ui <- fluidPage(
  
  
  plotOutput("volcano"),
  hr(),
  fluidRow(
    column(3,
           h4("Volcano plot"),
           br(),
    radioButtons("choice", "Data_type:",
                 c("tophat_rn4_untrimmed" = "tophat_rn4_untrimmed",
                   "tophat_rn4_trimmed" = "tophat_rn4_trimmed",
                   "tophat_rn6_untrimmed" = "tophat_rn6_untrimmed",
                   "tophat_rn6_trimmed" = "tophat_rn6_trimmed",
                   "rsem_rn4_untrimmed" = "rsem_rn4_untrimmed",
                   "rsem_rn4_trimmed" = "rsem_rn4_trimmed",
                   "rsem_rn6_untrimmed" = "rsem_rn6_untrimmed",
                   "rsem_rn6_trimmed" = "rsem_rn6_trimmed"))
    ),
    fluidRow(
      column(4,
    checkboxInput("showdots", label = "Only show from selected range?", value = FALSE),
    numericInput("logfc", label = h3("LogFC"), value = 1.5),
    numericInput("pvalue", label = h3("P value"), value = 0.05)
      )
  ) 
))

  



server <- function(input, output) {
  output$volcano <- renderPlot ({
   
    data_type <- switch (input$choice,
                         "tophat_rn4_untrimmed" = tophat_rn4_untrimmed,
                         "tophat_rn4_trimmed" = tophat_rn4_trimmed,
                         "tophat_rn6_untrimmed" = tophat_rn6_untrimmed,
                         "tophat_rn6_trimmed" = tophat_rn6_trimmed,
                         "rsem_rn4_untrimmed" = rsem_rn4_untrimmed,
                         "rsem_rn4_trimmed" = rsem_rn4_trimmed,
                         "rsem_rn6_untrimmed" = rsem_rn6_untrimmed,
                         "rsem_rn6_trimmed" = rsem_rn6_trimmed)
    
    plot(data_type$logFC, -log10(data_type$P.Value), pch=19, cex=0.2, col=ifelse(data_type$logFC < -input$logfc & data_type$P.Value<input$pvalue, "blue", ifelse(data_type$logFC > input$logfc & data_type$P.Value<input$pvalue, "red",if (input$showdots){"white"}else{"black"})), xlab = "logFC", ylab = "-log10(P-Val)",xlim=c(-10,10),ylim=c(0,10))
    abline(h=-log10(input$pvalue), col="blue")
    text(9,-log10(input$pvalue)+0.5,paste("P value",input$pvalue))
    abline(v=c(-input$logfc,input$logfc), col="green")
    text(-input$logfc,10,paste("LogFC",-input$logfc) )
    text(input$logfc,10,paste("LogFC",input$logfc))
    })
  
}

shinyApp(ui = ui, server = server)
