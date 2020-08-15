CREATE TABLE [exa].[EXAFIC](
    [EXAFICCOD] [int] IDENTITY(1,1) NOT NULL,
    [EXAFICEST] [int] NOT NULL,
    [EXAFICTEC] [int] NOT NULL,
    [EXAFICCOC] [int] NOT NULL,
    [EXAFICENC] [int] NOT NULL,
    [EXAFICEQC] [int] NOT NULL,
    [EXAFICPEC] [int] NOT NULL,
    [EXAFICAEC] [int] NULL,
    [EXAFICFE1] [date] NULL,
    [EXAFICFE2] [date] NULL,
    [EXAFICFE3] [date] NULL,
    [EXAFICACA] [int] NULL,
    [EXAFICMCA] [int] NULL,
    [EXAFICJCO] [char](2) NULL,
    [EXAFICJPO] [char](20) NULL,
    [EXAFICJCA] [char](20) NULL,
    [EXAFICLNO] [varchar](100) NULL,
    [EXAFICLFE] [date] NULL,
    [EXAFICLFR] [date] NULL,
    [EXAFICLFA] [date] NULL,
    [EXAFICLRE] [char](2) NULL,
    [EXAFICLIC] [char](2) NULL,
    [EXAFICLNT] [char](2) NULL,
    [EXAFICLAD] [varchar](MAX) NULL,
    [EXAFICLOB] [varchar](MAX) NULL,
    [EXAFICOBS] [varchar](MAX) NULL,
    [EXAFICAUS] [char](50) NOT NULL,
    [EXAFICAFH] [datetime] NOT NULL,
    [EXAFICAIP] [char](20) NOT NULL,
 CONSTRAINT [PK_EXAFICCOD] PRIMARY KEY CLUSTERED ([EXAFICCOD] ASC) WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]) ON [PRIMARY]
GO